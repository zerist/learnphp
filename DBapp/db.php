<?php
define("DB_INSERT", 1);
define("DB_REPLACE", 2);
define("DB_STORE", 3);
define("DB_BUCKET_SIZE", 262144);
define("DB_KEY_SIZE", 128);
define("DB_INDEX_SIZE", DB_KEY_SIZE + 12);
define("DB_KEY_EXISTS", 1);
define("DB_FAILURE", -1);
define("DB_SUCCESS", 0);

class DB{
    private $idx_fp;
    private $dat_fp;
    private $closed;

    public function open($pathname){
        $idx_path = $pathname.'.idx';
        $dat_path = $pathname.'.dat';
        if(!file_exists($idx_path)){
            $init = true;
            $mode = "w+b";
        }else{
            $init = false;
            $mode = "r+b";
        }
        $this->idx_fp = fopen($idx_path, $mode);
        if(!$this->idx_fp){
            return DB_FAILURE;
        }
        if($init){
            $elem = pack("L", 0x00000000);
            for($i=0; $i<DB_BUCKET_SIZE; $i++){
                fwrite($this->idx_fp, $elem, 4);
            }
        }
        $this->dat_fp = fopen($dat_path, $mode);
        if(!$this->dat_fp){
            return DB_FAILURE;
        }
        return DB_SUCCESS;
    }

    public function dbhash($string){
        $string = substr(md5($string), 0, 8);
        $hash = 0;
        for($i=0; $i<8; $i++){
            $hash += 33*$hash + ord($string[$i]);
        }
        return $hash & 0x7FFFFFFF;
    }

    public function fetch($key){
        $offset = ($this->dbhash($key) % DB_BUCKET_SIZE) * 4;
        fseek($this->idx_fp, $offset, SEEK_SET);
        $pos = unpack("L", fread($this->idx_fp, 4));
        $pos = $pos[1];
        $found = false;
        while ($pos){
            fseek($this->idx_fp, $pos, SEEK_SET);
            $block = fread($this->idx_fp, DB_INDEX_SIZE);
            $cpkey = substr($block, 4, DB_KEY_SIZE);
            if(!strncmp($key, $cpkey, strlen($key))){
                $dataoff = unpack("L", substr($block, DB_KEY_SIZE+4, 4));
                $dataoff = $dataoff[1];
                $datalen = unpack("L", substr($block, DB_KEY_SIZE+8, 4));
                $datalen = $datalen[1];
                $found = true;
                break;
            }
            $pos = unpack("L", substr($block, 0, 4));
            $pos = $pos[1];
        }
        if(!$found){
            return null;
        }
        fseek($this->dat_fp, $dataoff, SEEK_SET);
        $data = fread($this->dat_fp, $datalen);
        return $data;
    }

    public function insert($key, $data){
        $offset = ($this->dbhash($key) % DB_BUCKET_SIZE) * 4;
        $idxoff = fstat($this->idx_fp);
        $idxoff = intval($idxoff['size']);
        $datoff = fstat($this->dat_fp);
        $datoff = intval($datoff['size']);
        $keylen = strlen($key);
        if($keylen > DB_KEY_SIZE){
            return DB_FAILURE;
        }
        $block = pack("L", 0x00000000);
        $block .= $key;
        $space = DB_KEY_SIZE - $keylen;
        for($i=0; $i<$space; $i++){
            $block .= pack("C", 0x00);
        }
        $block .= pack("L", $datoff);
        $block .= pack("L", strlen($data));
        fseek($this->dat_fp, $offset, SEEK_SET);
        $pos = unpack("L", fread($this->idx_fp, 4));
        $pos = $pos[1];
        if($pos == 0){
            fseek($this->idx_fp, $offset, SEEK_SET);
            fwrite($this->idx_fp, pack("L", $idxoff), 4);
            fseek($this->idx_fp, 0, SEEK_END);
            fwrite($this->idx_fp, $block, DB_INDEX_SIZE);
            fseek($this->dat_fp, 0, SEEK_END);
            fwrite($this->dat_fp, $data, strlen($data));
            return DB_SUCCESS;
        }
        $found = false;
        while ($pos){
            fseek($this->idx_fp, $pos, SEEK_SET);
            $tmp_block = fread($this->idx_fp, DB_INDEX_SIZE);
            $cpkey = substr($tmp_block, 4, DB_KEY_SIZE);
            if(!strncmp($key, $cpkey, strlen($key))){
                $dataoff = unpack("L", substr($tmp_block, DB_KEY_SIZE + 4, 4));
                $dataoff = $dataoff[1];
                $datalen = unpack("L", substr($tmp_block, DB_KEY_SIZE + 8, 4));
                $datalen = $datalen[1];
                $found = true;
                break;
            }
            $prev = $pos;
            $pos = unpack("L", substr($tmp_block, 0, 4));
            $pos = $pos[1];
        }
        if($found){
            return DB_KEY_EXISTS;
        }
        fseek($this->idx_fp, $prev, SEEK_SET);
        fwrite($this->idx_fp, pack("L", $idxoff), 4);
        fseek($this->idx_fp, 0, SEEK_END);
        fwrite($this->idx_fp, $block, DB_INDEX_SIZE);
        fseek($this->dat_fp, 0, SEEK_END);
        fwrite($this->dat_fp, $data, strlen($data));
        return DB_SUCCESS;
    }

    public function delete($key){
        $offset = ($this->dbhash($key) % DB_BUCKET_SIZE) * 4;
        fseek($this->idx_fp, $offset, SEEK_SET);
        $head = unpack("L", fread($this->idx_fp, 4));
        $head = $head[1];
        $curr = $head;
        $prev = 0;
        $found = false;
        while ($curr){
            fseek($this->idx_fp, $curr, SEEK_SET);
            $block = fread($this->idx_fp, DB_INDEX_SIZE);
            $next = unpack("L", substr($block, 0, 4));
            $next = $next[1];
            $cpkey = substr($block, 4, DB_KEY_SIZE);
            if(!strncmp($key, $cpkey, strlen($key))){
                $found = true;
                break;
            }
            $prev = $curr;
            $curr = $next;
        }
        if(!$found){
            return DB_FAILURE;
        }
        if($prev == 0){
            fseek($this->idx_fp, $offset, SEEK_SET);
            fwrite($this->idx_fp, pack("L", $next),4);
        }else{
            fseek($this->idx_fp, $prev, SEEK_SET);
            fwrite($this->idx_fp, pack("L", $next), 4);
        }
        return DB_SUCCESS;
    }

    public function close(){
        if(!$this->closed){
            fclose($this->idx_fp);
            fclose($this->dat_fp);
            $this->closed = true;
        }
    }
}

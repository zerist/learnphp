<?php

class gbookModel
{
    private $bookPath;
    private $data;

    public function setBookPath($bookPath)
    {
        $this->bookPath = $bookPath;
    }

    public function getBookPath()
    {
        return $this->bookPath;
    }

    public function open()
    {
        //TODO
    }

    public function close()
    {

    }

    public function read()
    {
        return file_get_contents($this->bookPath);
    }


    public static function safe($data)
    {
        $reflect = new ReflectionObject($data);
        $props = $reflect->getProperties();
        $messagebox = new stdClass();
        foreach ($props as $prop) {
            $ivar = $prop->getName();
            $messagebox->$ivar = trim($prop->getValue($data));
        }
        return $messagebox;
    }

    public function write($data)
    {
        $this->data = self::safe($data)->name . "&" . self::safe($data)->email . "\nsaid:" . self::safe($data)->content . "\n";
        return file_put_contents($this->bookPath, $this->data, FILE_APPEND);
    }

    public function delete()
    {
        file_put_contents($this->bookPath, 'empty now');
    }
}

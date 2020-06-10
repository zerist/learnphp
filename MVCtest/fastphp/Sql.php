<?php
class Sql{
    protected $_dbHandle;
    protected $_result;

    //连接数据库
    public function connect($address, $user, $pwd, $dbname){
        $dsn = 'mysql:host=' . $address . ';dbname=' . $dbname;
        $this->_dbHandle = new PDO($dsn, $user, $pwd);
        $this->_dbHandle->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->_dbHandle->setAttribute("SET NAMES 'UTF8'");
        return $this->_dbHandle;
    }

    //关闭数据库
    public function disconnect(){
        $this->_dbHandle = null;
    }

    //查询所有
    public function selectAll(){
        $query = "select * from `" . $this->_table;
    }
}
<?php
class Database
{
    private static $db;
    private static $instance;

    private function __construct()
    {
        Database::$db = 1;
    }

    public static function getInstance(){
        if(Database::$instance == null){
            self::$instance = new Database();
            return self::$instance;

        }
        return self::$instance;
    }

    public function set($val){
        self::$db = $val;
    }

    public function show(){
        echo self::$db;
    }
}

$db = Database::getInstance();
$db->show();
$db->set(4);
$db->show();
$a = Database::getInstance();
$a->show();

<?php

class message
{
    public $name;
    public $email;
    public $content;

    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    public function __get($name)
    {
        if (!isset($this->$name)) {
            $this->$name = NULL;
        }
    }
}
<?php

class Person
{
    private $name;

    public function setName($name)
    {
        $this->name = $name;
    }

    public function show()
    {
        echo "装扮的{$this->name}";
    }
}
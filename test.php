<?php

interface mobile
{
    public function run();
}

class palin implements mobile
{
    public function run()
    {
        // TODO: Implement run() method.
        echo "a plain";
    }

    public function fly()
    {
        echo "fly";
    }
}

class car implements mobile
{
    public function run()
    {
        // TODO: Implement run() method.
        echo "a car";
    }
}

class machine
{
    public function demo(mobile $a)
    {
        $a->fly();
    }
}

$obj = new machine();
$obj -> demo( new palin());
//$obj -> demo( new car());

?>



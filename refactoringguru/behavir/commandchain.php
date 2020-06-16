<?php

namespace zerist\behavir\commandchain;

//command chain interface
use Monolog\Test\TestCase;

interface Handler
{
    public function setNext(Handler $handler): Handler;

    public function handle(string $req): ?string;
}

//basic chain class
abstract class AbstractHandler implements Handler
{
    private $nextHandler;

    public function setNext(Handler $handler): Handler
    {
        // TODO: Implement setNext() method.
        $this->nextHandler = $handler;
        return $handler;
    }


    public function handle(string $req): ?string
    {
        // TODO: Implement handle() method.
        if($this->nextHandler){
            return $this->nextHandler->handle($req);
        }
        return null;
    }
}

//concrete class
class MonkeyHandler extends AbstractHandler
{
    public function handle(string $req): ?string
    {
        if($req === "Banana"){
            return "Monkey: i will eat the " . $req . PHP_EOL;
        }else{
            return parent::handle($req);
        }
    }
}

class SquirrelHandler extends AbstractHandler
{
    public function handle(string $req): ?string
    {
        if($req === "Nut"){
            return "Squirrel: i will eat the " . $req . PHP_EOL;
        }else{
            return parent::handle($req);
        }
    }
}

class DogHandler extends AbstractHandler
{
    public function handle(string $req): ?string
    {
        if($req === "Meat"){
            return "Dog: i will eat the " . $req . PHP_EOL;
        }else{
            return parent::handle($req);
        }
    }
}

//client
function clientCode(Handler $handler){
    foreach (["Nut", "Banana", "Cup of Coffee"] as $food) {
        echo "Client: who wants a " . $food . "?\n";
        $result = $handler->handle($food);
        if($result){
            echo " " . $result;
        }else{
            echo " " . $food . " was left untouched.\n";
        }
    }
}


$monkey = new MonkeyHandler();
$squirrel = new SquirrelHandler();
$dog = new DogHandler();

$monkey->setNext($squirrel)->setNext($dog);
echo "chain: monkey > squirrel > dog \n\n";
clientCode($monkey);
echo '\n';

echo "subchain: squirrel > dog \n\n";
clientCode($squirrel);


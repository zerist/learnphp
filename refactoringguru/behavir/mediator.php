<?php
namespace zerist\behavir\mediator;

//mediator interface
use MongoDB\Driver\Command;

interface Mediator{
    public function notify(BaseComponent $sender, string $event) : void ;
}

//concrete mediator class
class ConcreMediator implements Mediator{
    private $component1;
    private $component2;

    public function __construct(BaseComponent $component1, BaseComponent $component2)
    {
        $this->component1 = $component1;
        $this->component1->setMediator($this);
        $this->component2 = $component2;
        $this->component2->setMediator($this);
    }

    public function notify(BaseComponent $sender, string $event): void
    {
        if($event == "A"){
            echo "mediator reacts on event A:\n";
            $sender->doA();
        }elseif($event == 'B'){
            echo "mediator reacts on event B:\n";
            $sender->doB();
        }elseif ($event == "C"){
            $sender->doC();
        }elseif ($event == 'D'){
            $sender->doD();
        }else{
            echo "erroe event $event\n";
        }
    }


}

//base component
class BaseComponent{
    protected $mediator;

    public function __construct(Mediator $mediator = null)
    {
        $this->mediator = $mediator;
    }

    public function setMediator(Mediator $mediator) : void {
        $this->mediator = $mediator;
    }
}

//concrete component
class Component1 extends BaseComponent{
    public function doA() : void {
        echo "component1 doA().\n";
        $this->mediator->notify($this, "A");
    }

    public function doB() : void {
        echo "component1 doB().\n";
        $this->mediator->notify($this, "B");
    }
}

class Component2 extends BaseComponent{
    public function doC():void {
        echo "component2 doC().\n";
        $this->mediator->notify($this, "C");
    }

    public function doD():void {
        echo "component2 doD().\n";
        $this->mediator->notify($this, "D");
    }
}

//client
$c1 = new Component1();
$c2 = new Component2();
$mediator = new ConcreMediator($c1, $c2);


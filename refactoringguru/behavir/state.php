<?php
namespace zerist\behavir\state;

//context manager
class Context{
    private $state;

    public function __construct(State $state)
    {
        $this->transitionTo($state);
    }

    public function transitionTo(State $state)  : void {
        echo "Context: transition to " . get_class($state) . ".\n";
        $this->state = $state;
        $this->state->setContext($this);
    }

    public function request1(){
        $this->state->handle1();
    }

    public function request2(){
        $this->state->handle2();
    }
}


//state abstract class
abstract class State
{
    protected $context;

    public function setContext(Context $context){
        $this->context = $context;
    }

    abstract public function handle1() : void ;
    abstract public function handle2() : void ;
}

//concrete state class
class ConcreteStateA extends State{
    public function handle1(): void
    {
        // TODO: Implement handle1() method.
        echo "ConcreteStateA handles request1.\n";
        echo "stateA turn to stateB.\n";
        $this->context->transitionTo(new ConcreteStateB());
    }

    public function handle2() :void {
        echo "constateA handles request2.\n";
    }
}

class ConcreteStateB extends State{
    public function handle1(): void
    {
        // TODO: Implement handle1() method.
        echo "constateB handles request1.\n";
    }

    public function handle2(): void
    {
        // TODO: Implement handle2() method.
        echo "constateB handles request2.\n";
        echo "stateB turn to stateA.\n";
        $this->context->transitionTo(new ConcreteStateA());
    }
}

//client
$context = new Context(new ConcreteStateA());
$context->request1();
$context->request2();

echo __NAMESPACE__ . PHP_EOL;

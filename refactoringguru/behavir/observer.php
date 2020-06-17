<?php
namespace zerist\behavir\observer;

//subject class
use SplObserver;
use SplSubject;

class Subject implements \SplSubject{
    public $state;

    private $observers;

    public function __construct()
    {
        $this->observers = new \SplObjectStorage();
    }

    public function attach(SplObserver $observer)
    {
        echo "subject: attached an observer.\n";
        $this->observers->attach($observer);
    }

    public function detach(SplObserver $observer)
    {
        echo "subject: detached an observer.\n";
        $this->observers->detach($observer);
    }

    public function notify()
    {
        echo "\nsubject: notifying all observers.\n";
        foreach ($this->observers as $observer){
            $observer->update($this);
        }
    }

    public function someBusinessLogic() : void {
        echo "\nsubject: do something.\n";
        $this->state = rand(0, 10);

        echo "subject: state changed to {$this->state}.\n";
        $this->notify();
    }
}


//concrete observer
class ConcreteObserverA implements \SplObserver
{
    public function update(SplSubject $subject)
    {
        if($subject->state < 3) {
            echo "ConcreteObserverA: react the event";
        }
    }
}

class ConcreteObserverB implements \SplObserver
{
    public function update(SplSubject $subject)
    {
        if($subject->state == 0 || $subject->state >= 2){
            echo "ConcreteObserverB: react the event";
        }
    }
}

//client
$subject = new Subject();

$o1 = new ConcreteObserverA();
$subject->attach($o1);

$o2 = new ConcreteObserverB();
$subject->attach($o2);

$subject->someBusinessLogic();
$subject->someBusinessLogic();
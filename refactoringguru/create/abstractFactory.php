<?php
namespace zerist\create\abstractFactory;

//product interface
interface Button{
    function paint();
}

//concrete product
class WinButton implements Button{
    public function paint()
    {
        // TODO: Implement paint() method.
        echo 'win button paint' . PHP_EOL;
    }
}

class MacButton implements Button{
    public function paint()
    {
        // TODO: Implement paint() method.
        echo 'mac button paint'. PHP_EOL;
    }
}

//interface product
interface Checkbox{
    function paint();
}

//concreate product
class WinCheckbox implements Checkbox{
    public function paint()
    {
        // TODO: Implement paint() method.
        echo 'win checkbox paint' . PHP_EOL;
    }
}

class MacCheckbox implements Checkbox{
    public function paint()
    {
        // TODO: Implement paint() method.
        echo 'mac checkbox paint' . PHP_EOL;
    }
}

//abstract factory
interface GUIFactory{
    function createBtn() : Button;
    function createCb() : Checkbox;
}

//concrete factory
class WinFactory implements GUIFactory{
    public function createBtn(): Button
    {
        // TODO: Implement createBtn() method.
        return new WinButton();
    }

    public function createCb(): Checkbox
    {
        // TODO: Implement createCb() method.
        return new WinCheckbox();
    }
}

class MacFactory implements GUIFactory{
    public function createBtn(): Button
    {
        // TODO: Implement createBtn() method.
        return new MacButton();
    }

    public function createCb(): Checkbox
    {
        // TODO: Implement createCb() method.
        return new MacCheckbox();
    }
}

//client app
class Application {
    private $factory;
    private $button;

    public function __construct(GUIFactory $factory)
    {
        $this->factory = $factory;
    }

    public function createBtn(){
        $this->button = $this->factory->createBtn();
    }

    public function createCb(){
        $this->button = $this->factory->createCb();
    }

    public function paint(){
        $this->button->paint();
    }
}

$app = new Application(new WinFactory());
$app->createBtn();
$app->paint();
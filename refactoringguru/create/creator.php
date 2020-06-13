<?php
namespace zerist\create\creator;

//product
class Car{
    public $name;
}

class Manual{
    public $name;
}

//interface builder
interface Builder {
    function reset();
    function setSeats(int $num);
    function setEngine(string $engine);
    function setTripComputer(string $computer);
    function setGPS(string $type);
}

//concrete builder
class CarBuilder implements Builder{
    private $car;

    public function __construct()
    {
        $this->reset();
    }

    public function reset()
    {
        // TODO: Implement reset() method.
        $this->car = new Car();
    }

    public function setSeats(int $num)
    {
        // TODO: Implement setSeats() method.
        $this->car->seats = $num;
    }

    public function setEngine(string $engine)
    {
        // TODO: Implement setEngine() method.
        $this->car->engine = $engine;
    }

    public function setTripComputer(string $computer)
    {
        // TODO: Implement setTripComputer() method.
        $this->car->computer = $computer;
    }

    public function setGPS(string $type)
    {
        // TODO: Implement setGPS() method.
        $this->car->GPS = $type;
    }

    public function getProduct() : Car
    {
        $product = $this->car;
        $this->reset();
        return $product;
    }
}

class ManualBuilder implements Builder{
    private $manual;

    public function __construct()
    {
        $this->reset();
    }

    public function reset()
    {
        // TODO: Implement reset() method.
        $this->manual = new Manual();
    }

    public function setSeats(int $num)
    {
        // TODO: Implement setSeats() method.
        $this->manual->seats = $num;
    }

    public function setEngine(string $engine)
    {
        // TODO: Implement setEngine() method.
        $this->manual->engine = $engine;
    }

    public function setGPS(string $type)
    {
        // TODO: Implement setGPS() method.
        $this->manual->GPS = $type;
    }

    public function setTripComputer(string $computer)
    {
        // TODO: Implement setTripComputer() method.
        $this->manual->computer = $computer;
    }

    public function getProduct() : Manual
    {
        $product = $this->manual;
        $this->reset();
        return $product;
    }
}

//director
class Director {
    private $builder;

    public function setBuilder(Builder $builder){
        $this->builder = $builder;
    }

    public function constructSportsCar(Builder $builder){
        $builder->reset();
        $builder->setSeats(4);
        $builder->setEngine('unreal4');
        $builder->setTripComputer('i7');
        $builder->setGPS('google');
    }
}

class Application{
    public function makeCar(){
        $director = new Director();

        $carbuilder = new CarBuilder();
        $director->constructSportsCar($carbuilder);
        $car = $carbuilder->getProduct();
        print_r((array)$car);
    }
}

$app = new Application();
$app->makeCar();

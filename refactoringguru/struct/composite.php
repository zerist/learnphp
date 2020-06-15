<?php
namespace zerist\struct\composite;

//componet interface
use phpDocumentor\Reflection\Types\This;

interface Graphic {
    function move(int $x, int $y);
    function draw();
}

//leaf node class
class Dot implements Graphic {
    public $x, $y;

    public function __construct(int $x, int $y)
    {
        $this->x = $x;
        $this->y = $y;
    }

    public function move(int $x, int $y)
    {
        // TODO: Implement move() method.
        $this->x += $x;
        $this->y += $y;
    }

    public function draw()
    {
        // TODO: Implement draw() method.
        echo "draw dot at ({$this->x}, {$this->y})" . PHP_EOL;
    }
}

class Circle extends Dot{
    public $radius;

    public function __construct(int $x, int $y, int $radius)
    {
        parent::__construct($x, $y);
        $this->radius = $radius;
    }

    public function draw()
    {
        echo "draw circle at ({$this->x}, {$this->y}, {$this->radius})" . PHP_EOL;
    }
}

//composite class
class CompoundGraphic implements Graphic {
    public $arrGraph = array();

    public function add(Graphic $graphic){
        $this->arrGraph[] = $graphic;
    }

    public function remove(Graphic $graphic){
        array_diff($this->arrGraph, [$graphic]);
    }

    public function move(int $x, int $y)
    {
        // TODO: Implement move() method.
        foreach ($this->arrGraph as $graph){
            $graph->move($x, $y);
        }
    }

    public function draw()
    {
        // TODO: Implement draw() method.
        foreach ($this->arrGraph as $graph){
            $graph->draw();
            //todo other cmd
        }
    }
}

//client class
class ImageEditor{
    public $arrGraph;

    public function __construct(){
        $this->arrGraph = new CompoundGraphic();
        $this->arrGraph->add(new Dot(1,2));
        $this->arrGraph->add(new Circle(5,3,10));
    }

    public function draw(){
        $this->arrGraph->draw();
    }
}

$app = new ImageEditor();
$app->draw();
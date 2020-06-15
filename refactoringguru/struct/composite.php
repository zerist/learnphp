<?php
namespace zerist\struct\composite;

//componet interface
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
        
    }
}

//client class
class ImageEditor{
    public $arrGraph;


}
<?php
namespace zerist\struct\adapter;

//client class
use phpDocumentor\Reflection\Types\This;

class RoundHole {
    public $radius;

    public function __construct(int $radius)
    {
        $this->radius = $radius;
    }

    public function getRadius(){
        return $this->radius;
    }

    public function fits(RoundPeg $peg) : bool {
        return $this->getRadius() >= $peg->getRadius();
    }
}

//class1
class RoundPeg {
    public $radius;

    public function __construct(int $radius)
    {
        $this->width = $radius;
    }

    public function getRadius(){
        return $this->radius;
    }
}

//class2
class SquarePeg {
    public $width;

    public function __construct($width)
    {
        $this->width = $width;
    }

    public function getWidth(){
        return $this->width;
    }
}

//adapter class
class SquarePegAdapter extends RoundPeg {
    private $squarepeg;

    public function __construct(SquarePeg $peg)
    {
        parent::__construct($peg->getWidth());
        $this->squarepeg = $peg;
    }

    public function getRadius()
    {
        return sqrt($this->squarepeg->getWidth() * $this->squarepeg->getWidth() * 2) / 2;
    }
}

//client
$hole = new RoundHole(5);
$rpeg = new RoundPeg(5);
echo $hole->fits($rpeg);

$small_sqpeg = new SquarePeg(5);
$large_sqpeg = new SquarePeg(10);
$small_adapter = new SquarePegAdapter($small_sqpeg);
$large_adapter = new SquarePegAdapter($large_sqpeg);
//echo $hole->fits($small_adapter);
//echo $hole->fits($large_adapter);

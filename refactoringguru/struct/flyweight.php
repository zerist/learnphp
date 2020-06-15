<?php
namespace zerist\struct\flyweight;

//inner class
use phpDocumentor\Reflection\Types\Self_;

class TreeType {
    public $name;
    public $color;
    public $texture;

    public function __construct(string $name, string $color, string $texture)
    {
        $this->name = $name;
        $this->color = $color;
        $this->texture = $texture;
    }

    public function draw($canvas, $x, $y){
        echo "create canvas {$canvas} at {$x},{$y}" . PHP_EOL;
    }
}

//outer class
class Tree{
    public $x, $y;
    public $treetype;

    public function __construct(int $x, int $y, TreeType $treeType)
    {
        $this->x = $x;
        $this->y = $y;
        $this->treetype = $treeType;
    }

    public function draw($canvas){
        $this->treetype->draw($canvas, $this->x, $this->y);
    }
}

//flyweight factory
//object manager
class TreeFactory{
    public static $treeTypes = array();

    public static function getTreeType($name, $color, $texture){
        $tmp = new TreeType($name, $color, $texture);
        if(!in_array($tmp, self::$treeTypes)){
            self::$treeTypes[] = $tmp;
            //echo 'add treetype' . PHP_EOL;
        }
        return $tmp;

    }
}

//client
class Forest{
    public $trees = array();

    public function plantTree($x, $y, $name, $color, $texture){
        $type = TreeFactory::getTreeType($name, $color, $texture);
        $tree = new Tree($x, $y, $type);
        $this->trees[] = $tree;
    }

    public function draw(){
        foreach ($this->trees as $tree){
            $tree->draw("canvas1");
        }
    }
}

$app = new Forest();
$app->plantTree(2,2, 't1', 'red', 'wood');
$app->plantTree(2,2, 't1', 'red', 'wood');
$app->plantTree(2,2, 't1', 'red', 'wood');
$app->plantTree(2,2, 't2', 'black', 'fe');
$app->plantTree(2,2, 't2', 'black', 'fe');
$app->draw();
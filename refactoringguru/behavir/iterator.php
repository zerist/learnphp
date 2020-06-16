<?php
namespace zerist\behavir\iterator;

//concrete iterator
class AlphabeticalOrderIterator implements \Iterator
{
    //collection var
    private $collection;

    //current index
    private $position = 0;

    //travel direction
    private $reverse = false;

    public function __construct($collection, $reverse = false)
    {
        $this->collection = $collection;
        $this->reverse = $reverse;
    }

    public function rewind()
    {
        $this->position = $this->reverse ? count($this->collection->getItems()) - 1 : 0;
    }

    public function current()
    {
        return $this->collection->getItems()[$this->position];
    }

    public function key()
    {
        return $this->position;
    }

    public function next()
    {
        $this->position = $this->position + ($this->reverse ? -1 : 1);
    }

    public function valid()
    {
        return isset($this->collection->getItems()[$this->position]);
    }

}

//concrete collection class
class WordsCollection implements \IteratorAggregate
{
    private $items = [];

    public function getItems()
    {
        return $this->items;
    }

    public function addItem($item){
        $this->items[] = $item;
    }

    public function getIterator() : \Iterator
    {
        return new AlphabeticalOrderIterator($this);
    }

    public function getReverseIterator():\Iterator{
        return new AlphabeticalOrderIterator($this, true);
    }
}

$collection = new WordsCollection();
$collection->addItem("First");
$collection->addItem("Second");
$collection->addItem("Third");
$collection->addItem("Abadon");

echo "straight traversal:\n";
foreach ($collection->getIterator() as $item){
    echo $item . "\n";
}
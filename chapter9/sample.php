<?php
class AlphabeticalOrderIterator implements \Iterator
{
    private $collection;
    private $reverse = false;
    private $position = 0;
    public function __construct($collection, $reverse = false)
    {
        $this->collection = $collection;
        $this->reverse = $reverse;
    }

    public function rewind(): void
    {
        $this->position = $this->reverse ? count($this->collection->getItems()) - 1 : 0;
    }

    public function current(): string
    {
        return $this->collection->getItems()[$this->position];
    }

    public function key(): int
    {
        return $this->position;
    }

    public function next(): void
    {
        $this->position = $this->position + ($this->reverse ? -1 : 1);
    }

    public function valid(): bool
    {
        return isset($this->collection->getItems()[$this->position]);
    }
}

class WordsCollection implements IteratorAggregate
{
    private $items = [];
    public function getItems(): array
    {
        return $this->items;
    }
    public function addItem($item): void
    {
        $this->items[] = $item;
    }
    public function getIterator(): Iterator
    {
        return new AlphabeticalOrderIterator($this);
    }

    public function getReverseIterator(): Iterator
    {
        return new AlphabeticalOrderIterator($this, true);
    }
}

$collection = new WordsCollection();
$collection->addItem("1");
$collection->addItem("2");
$collection->addItem("3");

echo "straight traversal:\n";
foreach ($collection->getIterator() as $item) {
    echo $item . "\n";
}

echo "reverse traversal:\n";
foreach ($collection->getReverseIterator() as $item) {
    echo $item . "\n";
}

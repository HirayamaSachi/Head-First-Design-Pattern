<?php
class CsvIterator implements Iterator
{
    const ROW_SIZE = 4096;
    protected $filePointer = null;
    protected $currentElement = null;
    protected $rowCounter = null;
    protected $delimiter = null;
    public function __construct($file, $delimiter = ',')
    {
        try {
            $this->filePointer = fopen($file, 'rb');
            $this->delimiter = $delimiter;
        } catch (\Throwable $th) {
            throw new Exception("The file" . $file . "cannot be read");
        }
    }
    public function rewind(): void
    {
        $this->rowCounter = 0;
        rewind($this->filePointer);
    }
    public function current(): mixed
    {
        $this->currentElement = fgetcsv($this->filePointer, self::ROW_SIZE, $this->delimiter);
        return $this->currentElement;
    }
    public function key(): mixed
    {
        return $this->rowCounter;
    }
    public function next(): void
    {
        if(!is_resource($this->filePointer) && !feof($this->filePointer)){
            fclose($this->filePointer);
        }
    }
    public function valid(): bool
    {
        if (!is_resource($this->filePointer) && !feof($this->filePointer)) {
            fclose($this->filePointer);
            return false;
        }
        return true;
    }
}

$csv = new CsvIterator(__DIR__ . '/cats.csv');
foreach ($csv as $key => $row) {
    print_r($row);
}

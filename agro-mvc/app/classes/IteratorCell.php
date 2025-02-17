<?php

namespace app\classes;

use Traversable;
use Iterator;

class IteratorCell implements Traversable, Iterator
{
  private $positionBody;
  private $headerCell;
  private $bodyCell;

  public function __construct($headerCell, $valueCell)
  {
    $this->headerCell = $headerCell;
    $this->bodyCell = $valueCell;
    $this->positionBody = 0;
  }

  public function next(): void
  {
    ++$this->positionBody;
  }

  public function rewind(): void
  {
    $this->positionBody = 0;
  }

  public function current(): array
  {
    return self::unionHeaderValue();
  }

  public function key(): mixed
  {
    return $this->positionBody;
  }

  public function valid(): bool
  {
    return isset($this->bodyCell[$this->positionBody]);
  }

  private function unionHeaderValue()
  {
    $positionHeader = 0;
    $entity = [];
    foreach ($this->bodyCell[$this->positionBody] as $value) {
      $entity[$this->headerCell[$positionHeader]] = $value;
      ++$positionHeader;
    }
    return $entity;
  }
}

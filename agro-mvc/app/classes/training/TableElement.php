<?php

namespace app\classes\training;

abstract class TableElement
{
  protected $element;

  public function __toString(): string
  {
    return $this->element;
  }

  public function __get(string $name): mixed
  {
    return $this->$name;
  }
}

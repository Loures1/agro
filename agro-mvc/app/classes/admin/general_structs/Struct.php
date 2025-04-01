<?php

namespace app\classes\admin\general_structs;

abstract class Struct
{
  protected $element;

  public function __toString(): string
  {
    return $this->element;
  }
}

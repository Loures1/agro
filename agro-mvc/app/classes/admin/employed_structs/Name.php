<?php

namespace app\classes\admin\employed_structs;

use app\classes\admin\employed_structs\Struct;

class Name extends Struct
{
  protected string $element;

  public function __construct(string $name)
  {
    $this->element = $name;
  }
}

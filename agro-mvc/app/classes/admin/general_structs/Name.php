<?php

namespace app\classes\admin\general_structs;

use app\classes\admin\general_structs\Struct;

class Name extends Struct
{
  protected string $element;

  public function __construct(string $name)
  {
    $this->element = $name;
  }
}

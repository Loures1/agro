<?php

namespace app\classes\admin\employed_structs;

use app\classes\admin\general_structs\Struct;

class Tel extends Struct
{
  protected string $element;

  public function __construct(string $tel)
  {
    $this->element = $tel;
  }
}

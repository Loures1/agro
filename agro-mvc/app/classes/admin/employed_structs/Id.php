<?php

namespace app\classes\admin\employed_structs;

use app\classes\admin\employed_structs\Struct;

class Id extends Struct
{
  protected int $element;

  public function __construct(int $id)
  {
    $this->element = $id;
  }
}

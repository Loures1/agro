<?php

namespace app\classes\admin\employed_structs;

use app\classes\admin\general_structs\Struct;

class Mat extends Struct
{
  public function __construct(string $mat)
  {
    $this->element = $mat;
  }
}

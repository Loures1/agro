<?php

namespace app\classes\admin\general_structs;

use app\classes\admin\general_structs\Struct;

class Id extends Struct
{
  public function __construct(int $id)
  {
    $this->element = $id;
  }
}

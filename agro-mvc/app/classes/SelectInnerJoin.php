<?php

namespace app\classes;

class SelectInnerJoin implements Query
{
  private ?string $query;
  
  public function getQuery(): string
  {
    return $this->query;
  }
}

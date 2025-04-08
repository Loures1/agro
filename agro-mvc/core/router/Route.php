<?php

namespace core\router;

use Attribute;
use core\uri\Method;

#[Attribute]
class Route
{
  public function __construct(private string $path, private Method $method) {}
}

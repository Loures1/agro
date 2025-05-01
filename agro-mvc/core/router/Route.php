<?php

namespace core\router;

use Attribute;
use core\uri\Method;

#[Attribute]
class Route
{
  public function __construct(private Method $method, private string $path, private TypeHint $set_request) {}
}

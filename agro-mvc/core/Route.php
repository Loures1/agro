<?php

namespace core;

use Attribute;
use core\enums\Method;

#[Attribute]
readonly class Router
{
  public function __construct(private string $path, private Method $method) {}
}

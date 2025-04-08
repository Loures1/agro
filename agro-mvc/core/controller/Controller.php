<?php

namespace core\controller;

use Attribute;

#[Attribute]
class Controller
{
  public function __construct(private string $name_controller) {}
}

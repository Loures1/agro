<?php

namespace core;

use app\classes\Uri;

class Method
{
  public function getMethod()
  {
    $method = explode('/', Uri::getUri());
    return (array_key_exists(2, $method)) ? $method[2] : 'null';
  }
}

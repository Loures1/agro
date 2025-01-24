<?php

namespace core;

use app\classes\Uri;

class Parameter
{
  public function getParameter()
  {
    $parameter = explode('/', Uri::getUri());
    return (array_key_exists(3, $parameter)) ? $parameter[3] : 'null';
  }
}

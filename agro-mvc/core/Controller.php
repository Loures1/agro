<?php

namespace core;

use app\classes\Uri;

class Controller
{
  static function getController()
  {
    $controller = explode('/', Uri::getUri());
    return (assertControllerHome(Uri::getUri())) ?
      'Home' : ucfirst($controller[1]);
  }

  public function contructController($controller)
  {
    $controller = 'app\controllers\\' . $controller;
    return new $controller;
  }
}

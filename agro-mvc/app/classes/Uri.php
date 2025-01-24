<?php

namespace app\classes;

class Uri
{
  static function getUri()
  {
    return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
  }

  public function getController() {}
  public function getMethod() {}
  public function getParameter() {}
}

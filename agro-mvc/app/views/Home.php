<?php

namespace app\views;

class ViewHome
{
  static function homePage()
  {
    return include_once("../public/html/homePage.html");
  }
}

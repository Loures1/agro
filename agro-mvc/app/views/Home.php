<?php

namespace app\views;

class ViewHome
{
  static function homePage()
  {
    return include_once("../public/assets/html/homePage.html");
  }
}

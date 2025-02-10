<?php

namespace app\views;

class ViewSignUp
{
  static function homePage()
  {
    return include_once("../public/html/signUp.html");
  }

  static function registerUserStatus()
  {
    return include_once("../public/html/reportStatus.html");
  }
}

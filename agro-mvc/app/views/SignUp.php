<?php

namespace app\views;

class ViewSignUp
{
  static function homePage()
  {
    return include_once("../public/assets/html/signUp.html");
  }

  static function registerUserStatus()
  {
    return include_once("../public/assets/html/reportStatus.html");
  }
}

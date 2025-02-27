<?php

namespace app\views;

class ViewSignIn
{
  static function homePage()
  {
    return include_once("../public/assets/html/signIn.html");
  }

  static function userAssert()
  {
    return include_once("../public/assets/html/reportStatusAssertUser.html");
  }
}

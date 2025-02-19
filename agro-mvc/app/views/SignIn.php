<?php

namespace app\views;

class ViewSignIn
{
  static function homePage()
  {
    return include_once("../public/html/signIn.html");
  }

  static function userAssert()
  {
    return include_once("../public/html/reportStatusAssertUser.html");
  }
}

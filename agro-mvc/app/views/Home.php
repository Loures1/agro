<?php

namespace app\views;

class HomeView
{
  public function homePage()
  {
    return include_once("../public/html/home_page.html");;
  }

  public function signInPage()
  {
    return include_once("../public/html/sign_in.html");
  }

  public function signUpPage()
  {
    return include_once("../public/html/sign_up.html");
  }
}

<?php

namespace app\controllers;

use core\Path;
use core\enums\Method;

#[Path(Method::GET, '/')]
class Home
{
  #[Path(Method::GET, '/')]
  public function landingPage(): void
  {
    echo true;
  }
}

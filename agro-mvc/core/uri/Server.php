<?php

namespace core\uri;

use core\uri\Method;

enum Server
{
  case Uri;
  case RequestMethod;

  public function value(): Method|string
  {
    return match ($this) {
      Server::Uri => parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH),
      Server::RequestMethod => ($_SERVER['REQUEST_METHOD'] == 'GET') ? Method::GET : Method::POST
    };
  }
}

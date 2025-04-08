<?php

namespace core\uri;

use core\uri\Server;

class Request
{
  public static function server(Server $requisition): string
  {
    return match ($requisition) {
      Server::Uri => parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH),
      Server::RequestMethod => $_SERVER['REQUEST_METHOD']
    };
  }
}

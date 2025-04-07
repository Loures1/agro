<?php

namespace core\uri;

class Request
{
  public static function server(string $uri): string
  {
    return parse_url($_SERVER[$uri], PHP_URL_PATH);
  }
}

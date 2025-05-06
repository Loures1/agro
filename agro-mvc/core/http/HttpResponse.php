<?php

namespace core\http;

class HttpResponse
{
  public static function redirect(string $url): void
  {
    header("Location: {$url}");
  }
}


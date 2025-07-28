<?php

namespace core\http;

use core\parser\Parser;
use function core\functions\plumb_identifier;

class HttpResponse
{
  public static function redirect(string $url): void
  {
    header("Location: {$url}");
  }

  public static function view(
    string $file_name,
    ?array $identifier = null
  ): void {
    $html_path = './assets/html/' . $file_name . '.html';
    $yield_html = Parser::generateCode(file_get_contents($html_path));
    if ($identifier) {
      $yield_html = plumb_identifier($identifier, $yield_html);
    }
    eval($yield_html);
  }

  public static function json(?array $json): void
  {
    echo json_encode($json);
  }
}

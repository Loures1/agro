<?php

namespace core\view;

use function core\view\functions\plumb_identifier;

class View
{
  public static function render(
    string $file_name,
    ?array $identifier
  ): void {
    $html_path = './assets/html/' . $file_name . '.html';
    $yield_html = Parser::generateCode(file_get_contents($html_path));
    if ($identifier) {
      $yield_html = plumb_identifier($identifier, $yield_html);
    }
    eval($yield_html);
  }
}


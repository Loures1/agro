<?php

namespace core\view;

use core\view\Token;
use core\view\exceptions\ErrorSyntax;

class Parser
{
  public static function generateCode(string $content): string
  {
    $content = array_map(
      fn($item) => preg_replace("/(?!\w)\s+(?![\w%}])/", b'', $item),
      explode("\n", $content)
    );

    foreach ($content as $key => &$item) {
      foreach (Token::cases() as $token) {
        if ($token == Token::ErrorSyntax) {
          ++$key;
          throw new ErrorSyntax(
            "Error Syntax line: {$key}"
          );
        }
        if (preg_match($token->value, $item)) {
          $item = $token->relation($item);
          break;
        }
      }
    }

    $content = implode("\n", $content);
    $content = "\$html = null;\n" . $content . "\necho \$html;";
    return $content;
  }
}

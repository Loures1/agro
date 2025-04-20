<?php

namespace core\view;

use core\view\Token;

class Lexer
{
  private array $tokens;

  public function __construct(string $path_file)
  {
    $file = file_get_contents($path_file);
    preg_match_all(
      RegexToken::expression(),
      $file,
      $matches,
      PREG_PATTERN_ORDER + PREG_UNMATCHED_AS_NULL
    );
    $this->tokens = [];
    foreach ($matches[0] as $key => $value) {
      foreach (RegexToken::getNames() as $type_token) {
        if ($matches[$type_token][$key] == $value) {
          $value = ($value == ' ') ? '\s' : $value;
          array_push($this->tokens, new Token($value, $type_token));
        }
      }
    }
  }

  public function __get(string $name): array
  {
    return match ($name) {
      'tokens' => $this->tokens
    };
  }
}

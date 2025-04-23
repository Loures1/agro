<?php

namespace core\view;

use core\view\exceptions\InvalidHtml;
use core\view\RegexToken;

class Parser
{
  public static function createQueue(string $path_file)
  {
    $file = file_get_contents($path_file);
    preg_match_all(
      RegexToken::expression(), 
      $file, 
      $matches, 
      PREG_PATTERN_ORDER + PREG_UNMATCHED_AS_NULL
    );
    $stack = [];
    foreach (RegexToken::cases() as $key => $enum) {
      $lexem = $matches[$enum->name][$key];
      if ($lexem == null) {
        throw new InvalidHtml(
          "Arquivo '{$path_file}' invalido. Falta da {$enum->name}"
        );
      }
      array_push($stack, $enum->ownerConstructor($lexem));
    }
    return $stack;
  }
}

<?php

namespace core\view;

use function core\functions\regex_match;

class Parser
{
  public function __construct(string $path_file)
  {
    $file = file_get_contents($path_file);
    foreach (RegexToken::cases() as $enum) {
      $node = current(
        regex_match(
          $enum->expression(),
          $file,
          fn($match) => ($match != null) ? $enum->nodeOwner($match) : null
        )
      );
      dd($node);
    }
  }
}

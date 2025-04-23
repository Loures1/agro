<?php

namespace core\view;

use core\view\RegexToken;

class Token
{
  private string $lexem;
  private RegexToken $type;
  public function __construct(string $lexem, RegexToken $type)
  {
    $this->lexem = $lexem;
    $this->type = $type;
  }

  public function __get(string $name): string
  {
    return match ($name) {
      'lexem' => $this->lexem,
      'type' => $this->type
    };
  }
}

<?php

namespace core\view;

class Token
{
  private string $lexem;
  private string $type;
  public function __construct(string $lexem, string $type)
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

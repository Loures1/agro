<?php

namespace core\view;

class Token
{
  public function __construct(private string $lexem, private string $type) {}

  public function __get(string $name): string
  {
    return match ($name) {
      'lexem' => $this->lexem,
      'type' => $this->type
    };
  }
}

<?php

namespace core\view;

use core\view\NodeHeader;

enum RegexToken
{
  case StructHeader;

  public function expression(): string
  {
    return match ($this) {
      self::StructHeader => "/(?<StructHeader>(?<={%\sheader\s%})[\\n\s\w:']+(?={% endheader %}))/"
    };
  }

  public function nodeOwner(string $input): object
  {
    return match ($this) {
      self::StructHeader => new NodeHeader($input)
    };
  }
}

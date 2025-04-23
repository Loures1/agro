<?php

namespace core\view;

use core\view\HeaderConstructor;
use core\view\BodyConstructor;

enum Group: string
{
  case Header = "(?<StructHeader>(?<={%\sheader\s%})[\\n\s\w:']+(?={%\sendheader\s%}))";
  case Body = "(?<StructBody>(?<={%\sbody\s%})[\\n\s<>\w{}%.\/]+((?={%\sendbody\s%})))";
  case Title = "(?<HeaderPathCss>(?<=title:'|title:\s')\w+(?='))";
  case PathCss = "(?<HeaderPathCss>(?<=css:'|css:\s')\w+(?='))";

  public static function expression(): string
  {
    $expression = array_map(
      fn (self $match) => $match->value,
      self::cases()
    );
    $expression = implode("|", $expression);
    return '/' . $expression . '/';
  }

  public function ownerConstructor(string $input): object
  {
    return match ($this) {
      self::StructHeader => new HeaderConstructor($input),
      self::StructBody => new BodyConstructor($input)
    };
  }
}

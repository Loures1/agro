<?php

namespace core\view;

use core\view\HeaderConstructor;
use core\view\BodyConstructor;
use core\view\Lexer;
use core\view\TypeGroup;

enum Group: string
{
  case Header = "(?<Header>(?<={%\sheader\s%})[\\n\s\w:']+(?={%\sendheader\s%}))";
  case Body = "(?<Body>(?<={%\sbody\s%})[\\n\s<>\w{}%.\/]+((?={%\sendbody\s%})))";
  case Title = "(?<Title>(?<=title:'|title:\s')\w+(?='))";
  case PathCss = "(?<PathCss>(?<=css:'|css:\s')\w+(?='))";

  public function ownerConstructor(string $input): mixed
  {
    return match ($this) {
      self::Header => Lexer::createQueue($input, TypeGroup::Header),
      self::Body => new BodyConstructor($input),
      self::Title, self::PathCss => $input,
    };
  }
}

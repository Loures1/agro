<?php

namespace core\view;

enum RegexToken: string
{
  case Reserved = '(?<Reserved>header|if|endif|else|for|endfor|in)';
  case OpeningBrace = '(?<OpeningBrace>{)';
  case ClosingBrace = '(?<ClosingBrace>})';
  case PercentSign = '(?<PercentSign>%)';
  case LessThan = '(?<LessThan><)';
  case GreaterThan = '(?<GreaterThan>>)';
  case String = '(?<String>["\/\w]+(?={)|(?<=})["\/\w]+|(?<=>).+(?=<))';
  case ForwardSlash = '(?<ForwardSlash>\/)';
  case Equal = '(?<Equal>=)';
  case Identifier = '(?<Identifier>[\w\.]+)';
  case Blank = '(?<Blank>\s+)';

  public static function expression(): string
  {
    $regex = array_map(
      fn($case) => $case->value,
      self::cases()
    );
    return '/' . implode('|', $regex) . '/';
  }

  public static function getNames(): array
  {
    $names = array_map(
      fn($case) => $case->name,
      self::cases()
    );

    return $names;
  }
}

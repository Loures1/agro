<?php

namespace core\parser;

use function core\functions\generate_for;
use function core\functions\generate_if;
use function core\functions\generate_tag_html;

enum Token: string
{
  case Comment = '/(?<Comment>(<--[\w\s\']*-->))/';
  case If = '/(?<If>({%\sif\s["\w=.\s]+%}))/';
  case Else = '/(?<Else>{%\selse\s%})/';
  case EndIF = '/(?<EndIf>){%\sendif\s%}/';
  case For = '/(?<For>({%\s)(for\s)(\w+)(\sin\s)(\w+)(\s%}))/';
  case EndFor = '/(?<EndFor>{%\sendfor\s%})/';
  case TagHtml = '/(?<TagHtml><.+>)/';
  case ErrorSyntax = b'';

  public function relation(string $content): mixed
  {
    preg_match_all($this->value, $content, $match);
    $match = $match[0];
    return match ($this) {
      self::If => generate_if($match[0]),
      self::Else => "} else {",
      self::EndIF => "}",
      self::For => generate_for($match[0]),
      self::EndFor => "}",
      self::TagHtml => generate_tag_html($match[0]),
      self::Comment => b''
    };
  }
}

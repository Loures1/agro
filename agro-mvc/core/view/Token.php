<?php

namespace core\view;

use function core\view\functions\generate_tag_html;

enum Token: string
{
  case If = '/(?<If>(?<={%\sif\s)\w+(?=\s%}))/';
  case Else = '/(?<Else>{%\selse\s%})/';
  case EndIF = '/(?<EndIf>){%\sendif\s%}/';
  case For = '/(?<For>(?<={%\sfor\s)\w+(?=\sin)|(?<=in\s)\w+(?=\s%}))/';
  case EndFor = '/(?<EndFor>{%\sendfor\s%})/';
  case TagHtml = '/(?<TagHtml><.+>)/';
  case ErrorSyntax = b'';

  public function relation(string $content): mixed
  {
    preg_match_all($this->value, $content, $match);
    $match = $match[0];
    return match ($this) {
      self::If => "if (\${$match[0]}) {",
      self::Else => "} else {",
      self::EndIF => "}",
      self::For => "foreach (\${$match[1]} as \${$match[0]}) {",
      self::EndFor => "}",
      self::TagHtml => generate_tag_html($match[0]),
    };
  }
}

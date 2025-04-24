<?php

namespace core\view;

use core\view\TypeGroup;
use core\view\Group;
use core\view\Lexer;

class HeaderConstructor
{
  private string $title;
  private string $path_css;

  public function __construct(string $content)
  {
    $values = Lexer::createQueue($content, TypeGroup::Header);
    [$this->title, $this->path_css] = $values; 
  }
}

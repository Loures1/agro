<?php

namespace core\view;

class HeaderConstructor
{
  private string $title;
  private string $path_css;

  public function __construct(string $content)
  {
    $content = explode("\r\n", $content);
  }
}

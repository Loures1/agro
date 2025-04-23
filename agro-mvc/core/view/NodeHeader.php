<?php

namespace core\view;

class NodeHeader
{
  private string $title;
  private string $path_css;

  public function __construct(string $content)
  {
    preg_match_all(
      "/(?<Title>(?<=title:\s)'\w+')|(?<CssPath>(?<=css:\s)'\w+')/",
      $content,
      $matches
    );

    dd($matches);
  }
}

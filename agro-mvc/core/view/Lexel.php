<?php

namespace core\view;

class Lexel
{
  private $teste;
  const EXPRESSION = "/(?<OpeningBrace>{)|(?<ClosingBrace>})|(?<PercentSing>%)|(?<Reserved>header|if|endif|else|for|endfor|in)|(?<TagHtmlStarting>(?=<)<\w+>)|(?<TagHtmlEnding>(?=<)<\/\w+>)|(?<String>(?<=>).+(?=<))|(?<Identifier>(?=[a-z])[\.\w_\d]+)|(?<Blank>\s\b|\b\s)/";
  public function __construct(string $path_file)
  {
    $file = file_get_contents($path_file);
    preg_match_all(
      self::EXPRESSION, 
      $file, 
      $matches, 
      PREG_PATTERN_ORDER + PREG_UNMATCHED_AS_NULL
    );  
    $this->teste = $matches;
  }
}

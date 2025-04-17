<?php

namespace core\view;

use core\view\Token;

class Lexer
{
  const EXPRESSION = "/(?<OpeningBrace>{)|(?<ClosingBrace>})|(?<PercentSign>%)|(?<Reserved>header|if|endif|else|for|endfor|in)|(?<TagHtmlStarting>(?=<)<\w+>)|(?<TagHtmlEnding>(?=<)<\/\w+>)|(?<String>(?<=>).+(?=<))|(?<Identifier>(?=[a-z])[\.\w_\d]+)|(?<Blank>\s\b|\b\s)/";

  private array $tokens;

  public function __construct(string $path_file)
  {
    $file = file_get_contents($path_file);
    preg_match_all(
      self::EXPRESSION,
      $file,
      $matches,
      PREG_PATTERN_ORDER + PREG_UNMATCHED_AS_NULL
    );
    $this->tokens = [];
    foreach ($matches[0] as $key => $value) {
      if ($matches['OpeningBrace'][$key] == $value) {
        array_push($this->tokens, new Token($value, 'OpeningBrace'));
      }
      if ($matches['ClosingBrace'][$key] == $value) {
        array_push($this->tokens, new Token($value, 'ClosingBrace'));
      }
      if ($matches['PercentSign'][$key] == $value) {
        array_push($this->tokens, new Token($value, 'PercentSign'));
      }
      if ($matches['Reserved'][$key] == $value) {
        array_push($this->tokens, new Token($value, 'Reserved'));
      }
      if ($matches['TagHtmlStarting'][$key] == $value) {
        array_push($this->tokens, new Token($value, 'TagHtmlStarting'));
      }
      if ($matches['TagHtmlEnding'][$key] == $value) {
        array_push($this->tokens, new Token($value, 'TagHtmlEnding'));
      }
      if ($matches['String'][$key] == $value) {
        array_push($this->tokens, new Token($value, 'String'));
      }
      if ($matches['Identifier'][$key] == $value) {
        array_push($this->tokens, new Token($value, 'Identifier'));
      }
      if ($matches['Blank'][$key] == $value) {
        array_push($this->tokens, new Token("\s", 'Blank'));
      }
    }
  }

  public function __get(string $name): array
  {
    return match ($name) {
      'tokens' => $this->tokens
    };
  }
}

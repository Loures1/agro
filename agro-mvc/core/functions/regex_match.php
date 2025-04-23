<?php

namespace core\functions;

function regex_match(
  string $expression, 
  string $subject, 
  ?callable $callable = null): array
{
  preg_match_all($expression, $subject, $matches);
  
  $matches = current($matches);

  if ($matches == null) {
    $matches = [0 => null];
  }

  if ($callable != null) {
    $matches = array_map(
      fn($item) => call_user_func($callable, $item),
      $matches
    );
  }
  return $matches;
}

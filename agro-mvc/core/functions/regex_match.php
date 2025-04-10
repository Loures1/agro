<?php

function regex_match(string $expression, string $subject, ?callable $function = null): array
{
  preg_match_all($expression, $subject, $matches);

  if ($function != null && $matches != null) {
    $array = [];
    foreach (current($matches) as $item) {
      $return = $function($item);
      if ($return != false) {
        array_push($array, $function($item));
      }
    }
    $matches = $array;
  }
  return $matches;
}

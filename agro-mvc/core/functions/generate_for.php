<?php

namespace core\functions;

function generate_for(string $content): string
{
  preg_match_all('/({%\sfor\s)(\w+)(\sin\s)(\w+)(\s%})/', $content, $match);
  $expression = "foreach (\${variable1} as \${variable0}) {";
  $expression = preg_replace(
    [
      '/{variable1}/',
      '/{variable0}/'
    ],
    [
      ...$match[4],
      ...$match[2]
    ],
    $expression
  );
  return $expression;
}


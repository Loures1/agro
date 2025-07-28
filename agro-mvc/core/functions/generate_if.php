<?php

namespace core\functions;

function generate_if(string $content): string
{
  if (preg_match_all('/({%\sif\s)(\w+\.?\w+)(\s==\s)(\w+\.?\w+)(\s%})/', $content, $match)) {
    $expression = "if (\${variable0} == \${variable1}) {\n";
    $expression = preg_replace(['/{variable0}/', '/{variable1}/'], [...$match[2], ...$match[4]], $expression);
    $expression = preg_replace(['/\./',], ['->'], $expression);
  }

  if (preg_match('/({%\sif\s)(\w+\.?\w+)(\s%})/', $content, $match)) {
    $expression = "if (\${variable}) {\n";
    $expression = preg_replace(['/{variable}/'], [$match[2]], $expression);
    $expression = preg_replace(['/\./'], ['->'], $expression);
  }

  if (preg_match_all('/({%\sif\s)(\w+\.?\w+)(\s==\s)("\w+\")(\s%})/', $content, $match)) {
    $expression = "if (\${variable0} == {variable1}) {\n";
    $expression = preg_replace(['/{variable0}/', '/{variable1}/'], [...$match[2], ...$match[4]], $expression);
    $expression = preg_replace(['/\./',], ['->'], $expression);
  }

  return $expression;
}

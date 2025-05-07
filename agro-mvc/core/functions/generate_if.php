<?php

namespace core\functions;

function generate_if(string $content): string
{
  if (preg_match_all('/({%\sif\s)(\w+\.?\w+)(\s==\s)(\w+\.?\w+)(\s%})/', $content, $match)) {
    $expression = "if (\${variable} == \${variable}) {\n";
    $expression = preg_replace(['/{variable}/'], [...$match[2], ...$match[4]], $expression);   
    $expression = preg_replace(['/\./',], ['->'], $expression);
    dd($expression);
  }

  if (preg_match('/({%\sif\s)(\w+\.?\w+)(\s%})/', $content, $match)) {
    $expression = "if (\${variable}) {\n";
    $expression = preg_replace(['/{variable}/'], [$match[2]], $expression);
    dd($expression);
  }

  if (preg_match('/({%\sif\s)(\w+)(\s%})/', $content)) {

  }
  return 'oi';
}
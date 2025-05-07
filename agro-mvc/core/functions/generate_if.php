<?php

namespace core\functions;

function generate_if(string $content): string
{
  return preg_replace(
    [
      '/{%\s/',
      '/(?<={%\sif)\s(?=[\w.=\s]+%})/',
      '/\s%}/'
    ],
    [
      b'',
      '){',
      '\s$'
    ],
    $content
  );
}

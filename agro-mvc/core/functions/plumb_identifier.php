<?php

namespace core\functions;

function plumb_identifier(array $identifier, string $content): string
{
  $keys = array_keys($identifier);
  foreach ($keys as $key) {
    $content = "\${$key} = \$identifier['{$key}'];\n" . $content;
  }
  return $content;
}


<?php

namespace core\view\functions;

function generate_tag_html(string $content): string
{
  if (preg_match('/(<\w+>\w*<\/\w+>)/', $content)) {
    return "\$html = \$html . '{$content}';";
  }

  $content = preg_replace(
    ['/(?<=\w)\.(?=\w+\s*}})/', '/"/', '/{{\s*/', '/\s*}}/'],
    ['->', '\"', '{$', '}'],
    $content
  );

  return "\$html = \$html . \"{$content}\";";
}

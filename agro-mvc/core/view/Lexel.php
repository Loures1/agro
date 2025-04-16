<?php

namespace core\view;

class Lexel
{
  const EXPRESSION = <<<EOD
  /(?<Reserved>header|if|endif|else|for|endfor|in)
  |(?<Identifier>(?=[a-z])[\w_\d]+)
  |(?<TagHtmlStarting><\w+>|<\w+\s+[\w="\/{{}}\.]+>)
  |(?<TagHtmlEnding>\/\w+>)
  |(?<OpeningBrace>{)
  |(?<ClosingBrace>})
  (?<PercentSing>%)/ 
  EOD;
}

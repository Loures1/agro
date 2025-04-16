<?php

namespace core\view;

enum TypeToken: string
{
  case Reserved = '/(?<Reserved>header|if|endif|else|for|endfor|in)/';
  case Identifier = '/(?<Identifier>)/';
  case OpeningBrace = '/(?<OpeningBrace>{)/';
  case ClosingBrace = '/(?<ClosingBrace>})/';
  case PercentSign = '/(?<PercentSing>%)/';
}

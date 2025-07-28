<?php

namespace core\router;

enum TypeHint
{
  case Parameter;
  case File;
  case Null;
  case Form;
  case Json;
}

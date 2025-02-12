<?php
require 'bootstrap.php';

use app\classes\ExtractorXlsx;

$extractor = new ExtractorXlsx(
  './tests/Profissoes_Industria_Polpa_Fruta.xlsx'
);

foreach ($extractor->getIterator() as $key => $value)
{
  print_r($value);
}

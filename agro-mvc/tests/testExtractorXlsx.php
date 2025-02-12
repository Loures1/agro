<?php
require 'bootstrap.php';

use app\classes\ExtractorXlsx;

$extractor = new ExtractorXlsx(
  './tests/Profissoes_Industria_Polpa_Fruta.xlsx'
);

foreach ($extractor as $key => $value)
{
  print($key . ' => ' . $value . "\n");
}
<?php

require 'bootstrap.php';

use app\classes\Prospector;

$extractor = new Prospector(
  './tests/Controle_de_Treinamentos.xlsx'
);

print_r($extractor->getRows(ALL_CELL));

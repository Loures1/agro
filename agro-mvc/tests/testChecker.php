<?php

require 'bootstrap.php';

use app\classes\Checker;
use app\classes\Prospector;

$extractor = new Prospector(
  './tests/Controle_Treinamentos.xlsx'
);

$checker = new Checker;
echo $checker->verification(HEADERS_CELL, $extractor->getRows(HEADERS_CELL));
echo $checker->verification(VALUES_CELL, $extractor->getRows(VALUES_CELL));

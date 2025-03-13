<?php

require 'bootstrap.php';

use app\classes\Prospector;

$extractor = new Prospector(
    './tests/Controle_Treinamentos.xlsx'
);

print_r($extractor->getRows(ALL));


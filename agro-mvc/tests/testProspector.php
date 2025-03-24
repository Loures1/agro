<?php

require 'bootstrap.php';

use app\classes\Prospector;
use app\classes\TablePath;

$file = [
  'name' => './tests/Controle_de_Treinamentos.xlsx',
  'tmp_name' => './tests/Controle_de_Treinamentos.xlsx',
];
$path = new TablePath($file);

$extractor = new Prospector($path);

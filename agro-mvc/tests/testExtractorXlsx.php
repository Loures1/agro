<?php
require 'bootstrap.php';

use app\classes\ExtractorXlsx;

$extractor1 = new ExtractorXlsx(
  './tests/Controle_Treinamentos.xlsx'
);

$extractor2 = new ExtractorXlsx(
  './tests/Profissoes_Industria_Polpa_Fruta.xlsx'
);

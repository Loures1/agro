<?php
require 'bootstrap.php';

use app\classes\ExtractorXlsx;

$extrector = new ExtractorXlsx(
  './tests/Profissoes_Industria_Polpa_Fruta.xlsx'
);

dd($extrector->getValeusFromTable());

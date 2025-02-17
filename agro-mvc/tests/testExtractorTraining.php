<?php

require 'bootstrap.php';

use app\classes\ExtractorTraining;

$extractor = new ExtractorTraining(
    './tests/Profissoes_Industria_Polpa_Fruta.xlsx'
);


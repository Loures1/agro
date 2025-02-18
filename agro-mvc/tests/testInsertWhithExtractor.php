<?php

require 'bootstrap.php';

use app\classes\ExtractorTraining;
use app\classes\Insert;

$extractor = new ExtractorTraining(
  './tests/Profissoes_Industria_Polpa_Fruta.xlsx'
);

foreach ($extractor->getDomainCellsTraining() as $training) {
  $datas = ['nome' => $training];
  $insert = new Insert('tbl_treinamento', $datas);
  echo $insert->getQuery() . "\n";
  $insert->execQuery();
}

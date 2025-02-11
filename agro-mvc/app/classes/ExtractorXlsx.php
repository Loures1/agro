<?php

namespace app\classes;

use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

define('START_ROW', 2);

class ExtractorXlsx
{
  private $values;
  public function __construct($path)
  {
    $reader = new Xlsx();
    $reader->setReadDataOnly(true);
    $this->values = self::extractRows($reader->load($path));
  }

  public function getValeusFromTable()
  {
    return $this->values;
  }

  private function extractRows($worksheet)
  {
    $professions = [];
    $worksheet = $worksheet->getActiveSheet();
    foreach ($worksheet->getRowIterator(START_ROW) as $row) {
      $entidade = [];
      foreach ($row->getCellIterator() as $cell) {
        if ($cell->getValue() != null) {
          array_push($entidade, $cell->getValue());
        }
      }
      $professions["{$entidade[0]}"] = array_slice($entidade, 1);
    }
    return $professions;
  }
}

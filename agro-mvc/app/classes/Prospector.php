<?php

namespace app\classes;

use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class Prospector
{
  private ?array $spreedSheet;

  public function __construct(?string $path)
  {
    $this->spreedSheet = [];
    $reader = new Xlsx();
    $reader->setReadDataOnly(TRUE);
    $spreedsheet = $reader->load($path);
    $worksheet = $spreedsheet->getActiveSheet();
    foreach ($worksheet->getRowIterator() as $row) {
      $cellIterator = $row->getCellIterator();
      $columns = [];
      foreach ($cellIterator as $cell) {
        array_push($columns, $cell->getValue());
      }
      array_push($this->spreedSheet, $columns);
    }
  }

  public function getRows(int $flag)
  {
    return match ($flag) {
      0 => $this->spreedSheet,
      1 => $this->spreedSheet[0],
      2 => array_slice($this->spreedSheet, 1)
    };
  }
}

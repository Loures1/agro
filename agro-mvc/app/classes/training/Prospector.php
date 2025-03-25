<?php

namespace app\classes\training;


use app\classes\training\Register;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class Prospector
{
  private Header $header;
  private Register $registers;

  public function __construct(TablePath $path)
  {
    $spreedSheet = [];
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
      array_push($spreedSheet, $columns);
    }
    $this->header = self::valiadeHeader($spreedSheet[0]);
    $this->registers = self::validadeRegisters(array_slice($spreedSheet, 1));
  }

  private function valiadeHeader(?array $header): Header
  {
    $header = new Header($header);
    return $header;
  }

  private function validadeRegisters(?array $registers): Register
  {
    $registers = new Register($registers);
    return $registers;
  }

  public function __get(?string $name): object
  {
    return match ($name) {
      HEADER => $this->header,
      REGISTERS => $this->registers
    };
  }
}

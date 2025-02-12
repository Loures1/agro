<?php

namespace app\classes;

use Iterator;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class ExtractorXlsx implements Iterator
{
  const START_ROW = 2;
  private int $positionKey;
  private int $positionValue;
  private array $valuesFromTable;
  private array $keysFromValues;

  public function __construct($path)
  {
    $reader = new Xlsx();
    $reader->setReadDataOnly(true);
    $this->valuesFromTable = self::extractRows($reader->load($path));
    $this->keysFromValues = array_keys($this->valuesFromTable);
    $this->positionKey = 0;
    $this->positionValue = 0;
  }

  public function getValeusFromTable() : array
  {
    return $this->valuesFromTable;
  }

  public function getKeysValues() : array
  {
    return $this->keysFromValues;
  }

  private function extractRows($worksheet) : array
  {
    $professions = [];
    $worksheet = $worksheet->getActiveSheet();
    foreach ($worksheet->getRowIterator(self::START_ROW) as $row) {
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

  public function current(): string
  {
    return $this->valuesFromTable[
      $this->keysFromValues[$this->positionKey]
    ][$this->positionValue];
  }

  public function next(): void
  {
    $lenValuesFromTable = count(
      $this->valuesFromTable[
        $this->keysFromValues[$this->positionKey]
      ]
    );

    if ($this->positionValue < $lenValuesFromTable - 1)
    {
      ++$this->positionValue;
    }else {
      ++$this->positionKey;
      $this->positionValue = 0;
    }
  }

  public function rewind(): void
  { 
    $this->positionKey = 0;
    $this->positionValue = 0;
  }

  public function key(): string
  { 
    return $this->keysFromValues[$this->positionKey];
  }

  public function valid(): bool
  { 
    return isset(
      $this->valuesFromTable[
        $this->keysFromValues[$this->positionKey]
      ][$this->positionValue]
    );
  }
}

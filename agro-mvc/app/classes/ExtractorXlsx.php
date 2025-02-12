<?php

namespace app\classes;

use IteratorAggregate;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use Traversable;

class ExtractorXlsx implements IteratorAggregate
{
  private array $cellsFromTable;
  private array $namesColumn;
  private array $values;

  public function __construct($path)
  {
    $reader = new Xlsx();
    $reader->setReadDataOnly(true);
    $this->cellsFromTable = self::extractRows($reader->load($path));
    $this->namesColumn = $this->cellsFromTable[0];
    $this->values = array_slice($this->cellsFromTable, 1);
  }

  public function getCellsFromTable() : array
  {
    return $this->cellsFromTable;
  }

  public function getColumn() : array
  {
    return $this->namesColumn;
  }

  public function getValuesRow() : array
  {
    return $this->values;
  }

  private function extractRows($worksheet) : array
  {
    $entitys = [];
    $worksheet = $worksheet->getActiveSheet();
    foreach ($worksheet->getRowIterator() as $row) {
      $entity = [];
      foreach ($row->getCellIterator() as $cell) {
        if ($cell->getValue() != null) {
          array_push($entity, $cell->getValue());
        }
      }
      array_push($entitys, $entity);
    }
    return $entitys;
  }

  public function getIterator() : Traversable
  {
    return new IteratorCell(
      headerCell: $this->namesColumn,
      valueCell: $this->values
    );
  }
}

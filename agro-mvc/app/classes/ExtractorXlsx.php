<?php

namespace app\classes;

use IteratorAggregate;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use Traversable;

class ExtractorXlsx implements IteratorAggregate
{
  private array $cells;
  private array $headerCells;
  private array $dataCells;

  public function __construct($path)
  {
    $reader = new Xlsx();
    $reader->setReadDataOnly(true);
    $this->cells = self::extractRows($reader->load($path));
    $this->headerCells = $this->cells[0];
    $this->dataCells = array_slice($this->cells, 1);
  }

  public function getAllCells() : array
  {
    return $this->cells;
  }

  public function getHeaderCells() : array
  {
    return $this->headerCells;
  }

  public function getDatasCells() : array
  {
    return $this->dataCells;
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
      headerCell: $this->headerCells
  ,
      valueCell: $this->dataCells
    );
  }
}

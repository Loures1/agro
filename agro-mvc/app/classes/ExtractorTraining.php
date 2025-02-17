<?php

namespace app\classes;

use app\classes\ExtractorXlsx;

class ExtractorTraining extends ExtractorXlsx
{
  private ?array $cellsTraining;
  private ?array $domainCellsTraining;
  public function __construct($path)
  {
    parent::__construct($path);
    $this->cellsTraining = [];
    foreach (parent::getDatasCells() as $rowOfTraining) {
      array_push($this->cellsTraining, array_slice($rowOfTraining, 1));
    }
    $this->domainCellsTraining = self::formDomainCellsTraining();
  }

  public function getCellsTraining(): array
  {
    return $this->cellsTraining;
  }

  public function getDomainCellsTraining(): array
  {
    return $this->domainCellsTraining;
  }

  private function formDomainCellsTraining(): array
  {
    $domainCellsTraining = [];
    foreach ($this->cellsTraining as $rowOfTraining) {
      foreach ($rowOfTraining as $cell) {
        if (count($domainCellsTraining) == null) {
          array_push($domainCellsTraining, $cell);
        } elseif (!in_array($cell, $domainCellsTraining)) {
          array_push($domainCellsTraining, $cell);
        }
      }
    }
    sort($domainCellsTraining);
    return $domainCellsTraining;
  }
}

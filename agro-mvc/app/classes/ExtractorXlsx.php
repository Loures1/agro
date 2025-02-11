<?php

namespace app\classes;

use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class ExtractorXlsx
{
    public $struture_xlsx;
    public function __construct($path)
    {
        $reader = new Xlsx();
        $reader->setReadEmptyCells(false);
        $this->struture_xlsx = $reader->load($path);
        return $this->struture_xlsx->getActiveSheet();     
    }

    private function extractColumn()
    {
        $professions = [];
        $worksheet = $this->struture_xlsx->getActiveSheet();
        foreach($worksheet->getColumnIterator() as $column)
        {
            foreach($column->getCellIterator() as $cell)
            {
                echo $cell;
                echo '<br>'; 
            }
        } 
    }
}
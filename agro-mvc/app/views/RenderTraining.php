<?php

namespace app\views;

class RenderTraining
{
    private ?array $reportTraining;
    private ?array $metaData;
    private ?string $nameEmployed;
    private ?string $fileHtml;

    public function __construct(?array $reportTraining)
    {
        $this->nameEmployed = $reportTraining['name'];
        $this->reportTraining = $reportTraining['training'];
        $this->metaData = $reportTraining['meta_data'];
    }

    private function generateTable()
    {

    }

    private function renderHtml()
    {
        $fields = [
            "EMPLOYED_NAME" => "{$this->nameEmployed}",
            "TRAINING_REPORT_STATUS_1" => null,
            "TRAINING_REPORT_STATUS_0" => null
        ];

        foreach($this->reportTraining as $item)
        {

        }
    }
}
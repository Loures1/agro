<?php

namespace app\views;

class RenderTraining
{
  const FIELD_EMPLOYED_NAME = '/<!--EMPLOYED_NAME-->/';
  const FIELD_HERID_PROFESSION = '/<!--HERID_PROFESSION-->/';
  const FIELD_TRAINING_NUMBER = '/<!--TRAINING_NUMBER-->/';
  const FIELD_TABLE_TRAINING_GRADUATE = '/<!--TABLE_TRAINING_GRADUATE-->/';
  const
    FIELD_TABLE_TRAINING_NOT_GRADUATE = '/<!--TABLE_TRAINING_NOT_GRADUATE-->/';
  private ?array $reportTraining;
  private ?array $metaData;
  private ?string $nameEmployed;
  private ?string $professionEmployed;

  public function __construct(?array $reportTraining)
  {
    $this->nameEmployed = $reportTraining['nameEmployed'];
    $this->professionEmployed = $reportTraining['professionEmployed'];
    $this->reportTraining = $reportTraining['trainingStatus'];
    $this->metaData = $reportTraining['meta_data'];
  }

  public function view(?string $pathHtml): void
  {
    echo preg_replace(
      [
        self::FIELD_EMPLOYED_NAME,
        self::FIELD_HERID_PROFESSION,
        self::FIELD_TRAINING_NUMBER,
        self::FIELD_TABLE_TRAINING_GRADUATE,
        self::FIELD_TABLE_TRAINING_NOT_GRADUATE
      ],
      [
        $this->nameEmployed,
        $this->professionEmployed,
        self::getTrainingNumber(),
        self::mountTableTrainingGraduate(),
        self::mountTableTrainingNotGraduate()
      ],
      file_get_contents($pathHtml)
    );
  }

  private function mountTableTrainingGraduate(): string
  {
    $fields = <<<HTML
      <tr>
        <th>Cursos Graduados</th>
        <th>Validade</th>
      </tr>
      HTML;
    foreach ($this->reportTraining[1] as $item) {
      $point_data = date('d-m-Y', strtotime($item[1]));
      $fields = $fields . <<<HTML
        <tr>
          <td>{$item[0]}</td>
          <td>{$point_data}</td>
        </tr>
        HTML;
    }
    return $fields;
  }

  private function mountTableTrainingNotGraduate(): string
  {
    $fields = <<<HTML
      <tr>
        <th>Cursos Nao Graduados</th>
      </tr>
      HTML;
    foreach ($this->reportTraining[0] as $item) {
      $fields = $fields . <<<HTML
        <tr>
          <td>{$item}</td>
        </tr>
        HTML;
    }
    return $fields;
  }

  private function getTrainingNumber(): int
  {
    return
      $this->metaData['status_1_number'] + $this->metaData['status_0_number'];
  }
}

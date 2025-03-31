<?php

namespace app\models;

use app\classes\training\Employed;
use app\classes\training\Job;
use app\classes\training\TrainingRegister;
use app\models\Query;

class ModelRegister extends Query
{
  private $id;

  public function __construct(string $name, string $target)
  {
    $code = preg_replace(
      ['/{target}/', '/{name}/'],
      [$target, $name],
      GET_ID
    );
    parent::__construct();
    $return = parent::execQuery($code);
    $id = $return->fetch_row();
    $this->id = ($id == null) ? null : $id[0];
  }

  private static function validadeRelation(
    Employed $employed,
    Job $job,
    TrainingRegister $training
  ): bool {
    $code = preg_replace(
      ['/{id_employed}/', '/{id_job}/', '/{id_training}/'],
      [$employed->id, $job->id, $training->id],
      RELATION
    );
    $database = new Query;
    $return = $database->execQuery($code);
    return $return->fetch_row()[0];
  }

  public static function __callStatic(string $name, ?array $register): bool
  {
    return match ($name) {
      VALIDADE_RELATION => self::validadeRelation(...$register)
    };
  }

  public function __get(string $name): null|int
  {
    return match ($name) {
      ID => $this->id
    };
  }
}

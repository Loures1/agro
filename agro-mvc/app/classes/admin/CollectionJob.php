<?php

namespace app\classes\admin;

use app\classes\admin\Job;
use app\models\ModelAdmin;

class CollectionJob
{
  private array $jobs;

  public function __construct(ModelAdmin $model)
  {
    $this->jobs = [];
    foreach ($model->jobs as $job) {
      # to do the ModelAdmin search the job through of the id
      $job = self::createJob(...$job);
      self::push($job);
    };
  }

  private function createJob(int $id, string $name, string $date): Job
  {
    $job = new Job($id, $name, $date);
    return $job;
  }

  private function push(Job $job): void
  {
    array_push($this->jobs, $job);
  }
}

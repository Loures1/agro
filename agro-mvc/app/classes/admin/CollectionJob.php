<?php

namespace app\classes\admin;

use app\classes\admin\Job;

class CollectionJob
{
  private array $jobs;

  public function __construct(?array $jobs)
  {
    $this->jobs = [];
    foreach ($jobs as $id => $job) {
      $job = self::createJob($id, ...$job);
      self::push($job);
    };
  }

  private function createJob(
    int $id,
    string $name,
    string $date,
    ?array $trainings
  ): Job {
    $job = new Job($id, $name, $date, $trainings);
    return $job;
  }

  private function push(Job $job): void
  {
    array_push($this->jobs, $job);
  }

  public function __get(string $name): array
  {
    return match ($name) {
      'jobs' => $this->jobs
    };
  }
}

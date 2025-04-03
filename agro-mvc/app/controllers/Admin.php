<?php

namespace app\controllers;

use app\classes\admin\CollectionEmployed;
use app\classes\admin\CollectionJob;
use app\classes\admin\CollectionTraining;
use app\classes\admin\RelationStructs;
use app\models\ModelAdmin;

class Admin
{
  public function null(): void
  {
    $relationStructs = new RelationStructs;
    $colletcionTraining = new CollectionTraining($relationStructs->trainings);
    $colletcionJobs = new CollectionJob($relationStructs->jobs);
    $colletcionEmployed = new CollectionEmployed();
  }
}

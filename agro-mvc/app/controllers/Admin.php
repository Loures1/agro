<?php

namespace app\controllers;

use app\classes\admin\CollectionJob;
use app\classes\admin\CollectionTraining;
use app\models\ModelAdmin;

class Admin
{
  public function null(): void
  {
    $modelAdmin = new ModelAdmin();
    $collectionJob = new CollectionJob($modelAdmin);
    dd($collectionJob);
  }
}

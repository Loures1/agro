<?php

namespace app\controllers;

use app\classes\admin\CollectionJob;
use app\classes\admin\CollectionTraining;
use app\classes\admin\RelationStructs;
use app\models\ModelAdmin;

class Admin
{
  public function null(): void
  {
    $relationStructs = new RelationStructs;
    dd($relationStructs->jobs[1]);
  }
}

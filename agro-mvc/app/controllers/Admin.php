<?php

namespace app\controllers;

use app\classes\admin\CollectionEmployed;
use app\classes\admin\CollectionJob;
use app\classes\admin\CollectionTraining;
use app\classes\admin\relation\RelationEmploeyd;
use app\classes\admin\relation\RelationJob;
use core\Route;
use core\controller\Controller;
use core\uri\Method;

#[Controller('Admin')]
class Admin
{
  #[Route(Method::GET, '/admin')]
  public function null(): void
  {
    $relationJob = new RelationJob;
    $relationEmployed = new RelationEmploeyd;
    $collectionTraining = new CollectionTraining($relationJob->trainings);
    $collectionJob = new CollectionJob($relationJob->jobs);
    $collectionEmployed = new CollectionEmployed($relationEmployed->employeds);
  }
}

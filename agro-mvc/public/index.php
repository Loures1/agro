<?php
require '../bootstrap.php';

use core\controller\ExtractorControllers;
use core\controller\DirController;

dd(ExtractorControllers::get(DirController::Path));

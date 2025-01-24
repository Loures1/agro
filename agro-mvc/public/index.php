<?php
require '../bootstrap.php';

use core\Controller;
use core\Method;
use core\Parameter;

$controller = new Controller;
$controller = $controller->contructController(Controller::getController());

$method = new Method;
$method = $method->getMethod();

$parameter = new Parameter;
$parameter = $parameter->getParameter();

$controller->$method($parameter);

<?php

include_once('../script/controller.php');
$controller = new Controller();
$controller->method = $_SERVER['REQUEST_METHOD'];
$controller->params = $_GET;
var_dump($controller());

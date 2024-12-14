<?php

include_once('../script/controller.php');
include_once('../script/Tokyo3.php');
/*
$controller = new Controller();
$controller->method = $_SERVER['REQUEST_METHOD'];
$controller->params = $_GET;
var_dump($controller());
 */
$tokyo3 = new Tokyo3();
$tokyo3->operation = 'SELECT';
$tokyo3->target = 'tbl_supervisor';
$tokyo3->params = array(
  'nome' => 'Lucas',
  'cpf' => '123',
  'telefone' => '123',
  'email' => 'lucasantonio.loures@gmail.com',
  'senha' => '123',
  'status' => '1'
);
var_dump($tokyo3());

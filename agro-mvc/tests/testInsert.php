<?php

use app\classes\Insert;

require 'bootstrap.php';

$data = [
  "nome" => "Lucas",
  "idade" => "22",
  "cpf" => "159.074.316-44"
];

$insert = new Insert('tbl_supervisor', $data);

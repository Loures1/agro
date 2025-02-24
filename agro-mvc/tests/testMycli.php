<?php

use config\Credentials;

require 'bootstrap.php';

$teste = new mysqli(
  hostname: '0.0.0.0:3306',
  username: Credentials::USERNAME,
  password: Credentials::PASSWORD,
  database: Credentials::DATABASE
);

$result = $teste->query("SELECT f.id FROM tbl_funcionario as f WHERE f.nome = 'Maria Oliveira'")->fetch_row();

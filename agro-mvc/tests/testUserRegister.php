<?php

use app\models\User;

require 'bootstrap.php';

$userModel = new User;
$userModel->registerUser(
    'tbl_supervisor',
    [
        'nome' => 'Lucas Loures',
        'telefone' => '111111111111',
        'cpf' => '159.074.316-44',
        'email' => 'teste@gmail.com',
        'senha' => '123'
    ]);
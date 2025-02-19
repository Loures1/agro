<?php

use app\models\User;

require 'bootstrap.php';

$userModel = new User;
echo $userModel->assertUser(
    'tbl_supervisor',
    ['*'],
    'id = 22'
) == false;
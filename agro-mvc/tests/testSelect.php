<?php

use app\classes\Select;

require 'bootstrap.php';

$select = new Select(
    fields: ['*'],
    target: 'tbl_supervisor',
    condition: 'id = 1'
);
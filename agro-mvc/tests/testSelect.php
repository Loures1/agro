<?php

use app\classes\Select;

require 'bootstrap.php';

$select = new Select(
    fields: ['nome'],
    target: 'tbl_supervisor',
    condition: null
);

$select->execQuery();
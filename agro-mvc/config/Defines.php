<?php
//Class Register
define('EMPLOYED',        0);
define('JOB',             1);
define('TRAINING',        2);
define('STATUS_TRAINING', 3);
define('DATE',            4);

//Class Prospector
define('HEADER',       'header');
define('REGISTERS', 'registers');

//Class ModelRegister, Employed, Job, Training
define('ID', 'id');

//Class ModelRegister
define('VALIDADE_RELATION', 'validadeRelation');

//Class HeaderModel
define('ONE_COLUMN',   0);
define('TWO_COLUMN',   1);
define('THREE_COLUMN', 2);
define('FOR_COLUMN',   3);
define('FIVE_COLUMN',  4);
define('COLUMN_NUM',   5);

//Data Credentials
define('HOSTNAME', $_ENV['HOSTNAME_DATABASE']);
define('PASSWORD', $_ENV['PASSWORD_DATABASE']);
define('USERNAME', $_ENV['USERNAME_DATABASE']);
define('DATABASE', $_ENV['DATABASE']);

//Data Base Tables
define('TBL_EMPLOYED',                   $_ENV['EMPLOYED']);
define('TBL_JOB',                             $_ENV['JOB']);
define('TBL_TRAINING',                   $_ENV['TRAINING']);
define('TBL_EMPLOYED_TRAINING', $_ENV['EMPLOYED_TRAINING']);


//Data Base SQL Code
define('UPDATE',     $_ENV['SQL_UPDATE']);
define('RELATION', $_ENV['SQL_RELATION']);
define('GET_ID',     $_ENV['SQL_GET_ID']);
define('SELECT_EMPLOYED', $_ENV['SQL_SELECT_EMPLOYED']);
define('SELECT_JOB', $_ENV['SQL_SELECT_JOB']);
define('SELECT_TRAINING', $_ENV['SQL_SELECT_TRAINING']);
define('SELECT_JOB_TRAINING', $_ENV['SQL_SELECT_JOB_TRAINING']);
define('SELECT_EMPLOYED_TRAINING', $_ENV['SQL_SELECT_EMPLOYED_TRAINING']);

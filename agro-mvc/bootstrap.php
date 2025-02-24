<?php
require 'app/functions/helpers.php';
require 'app/classes/Uri.php';
require 'app/classes/Query.php';
require 'app/classes/Insert.php';
require 'app/classes/Select.php';
require 'app/classes/SelectExists.php';
require 'app/classes/ExtractorXlsx.php';
require 'app/classes/IteratorCell.php';
require 'app/classes/ExtractorTraining.php';
require 'core/Controller.php';
require 'core/Method.php';
require 'core/Parameter.php';
require 'app/controllers/Home.php';
require 'app/controllers/SignUp.php';
require 'app/controllers/SignIn.php';
require 'app/models/User.php';
require 'app/views/Home.php';
require 'app/views/SignUp.php';
require 'app/views/SignIn.php';
require 'config/CredentialsDB.php';
require 'vendor/autoload.php';

#.env
$_ENV = parse_ini_file('.env');
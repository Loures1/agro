<?php
require '../bootstrap.php';

use core\router\Routing;
use core\view\Parser;
use core\view\TypeGroup;

dd(TypeGroup::getGroup(TypeGroup::Struct));
$stack = Parser::createQueue('./assets/html/home_page.html');
dd($stack);

<?php
require '../bootstrap.php';

use core\router\Routing;
use core\view\Lexer;
use core\view\TypeGroup;

$queue = Lexer::createQueue(
    file_get_contents('./assets/html/home_page.html'),
    TypeGroup::Struct
);
dd($queue);

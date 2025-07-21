<?php

namespace tests\admin;

define("HOSTNAME", "localhost");
define("USERNAME", "root");
define("PASSWORD", '');
define("DATABASE", "agro");

use PHPUnit\Framework\TestCase;
use app\controllers\Admin;

class AdminTest extends TestCase
{
  public function test_create_employed(): void
  {
    $admin = new Admin;
    $data = [
      'target' => 'employed',
      'id' => null,
      'name' => 'LucasAk',
      'mat' => 'MAT021',
      'trainings' => [
        'remove' => [],
        'add' => ["1", "2"]
      ],
      'tel' => '(92) 981114-3791',
      'email' => 'test@gmail.com'
    ];
    $admin->receiveCreateJson($data);
  }
}

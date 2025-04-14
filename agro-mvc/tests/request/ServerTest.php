<?php

namespace tests\request;

use PHPUnit\Framework\TestCase;
use core\uri\Method;
use core\uri\Server;

class ServerTest extends TestCase
{
  public function test_Server_get(): void
  {
    $_SERVER['REQUEST_METHOD'] = 'GET';
    $method = Server::RequestMethod;
    $this->assertEquals(Method::GET, $method->value());
  }

  public function test_Servet_post(): void
  {
    $_SERVER['REQUEST_METHOD'] = 'POST';
    $method = Server::RequestMethod;
    $this->assertEquals(Method::POST, $method->value());
  }
}

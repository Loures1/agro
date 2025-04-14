<?php

namespace tests\request;

require 'core/functions/regex_match.php';

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\TestDox;
use core\uri\Method;
use core\uri\Request;

class RequestTest extends TestCase
{
  #[TestDox("METHOD: GET, URI: /training/get/mat001")]
  public function test_uri_1(): void
  {
    $_SERVER['REQUEST_METHOD'] = 'GET';
    $_SERVER['REQUEST_URI'] = '/training/get/mat001';
    $request = new Request;
    $this->assertEquals('Training', $request->controller);
    $this->assertEquals('get', $request->method);
    $this->assertEquals('mat001', $request->parameter);
    $this->assertEquals(Method::GET, $request->request_method);
  }

  #[TestDox("METHOD: GET, URI: /training/get")]
  public function test_uri_2(): void
  {
    $_SERVER['REQUEST_METHOD'] = 'GET';
    $_SERVER['REQUEST_URI'] = '/training/get';
    $request = new Request;
    $this->assertEquals('Training', $request->controller);
    $this->assertEquals('get', $request->method);
    $this->assertEquals(null, $request->parameter);
    $this->assertEquals(Method::GET, $request->request_method);
  }

  #[TestDox("METHOD: GET, URI: /training")]
  public function test_uri_3(): void
  {
    $_SERVER['REQUEST_METHOD'] = 'GET';
    $_SERVER['REQUEST_URI'] = '/training';
    $request = new Request;
    $this->assertEquals('Training', $request->controller);
    $this->assertEquals(null, $request->method);
    $this->assertEquals(null, $request->parameter);
    $this->assertEquals(Method::GET, $request->request_method);
  }

  #[TestDox("METHOD: GET, URI: /")]
  public function test_uri_4(): void
  {
    $_SERVER['REQUEST_METHOD'] = 'GET';
    $_SERVER['REQUEST_URI'] = '/';
    $request = new Request;
    $this->assertEquals('Home', $request->controller);
    $this->assertEquals(null, $request->method);
    $this->assertEquals(null, $request->parameter);
    $this->assertEquals(Method::GET, $request->request_method);
  }
}

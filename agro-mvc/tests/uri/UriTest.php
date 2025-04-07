<?php

namespace tests;

use PHPUnit\Framework\Attributes\TestDox;
use core\uri\Uri;
use PHPUnit\Framework\TestCase;
use core\expections\InvalidUri;

class UriTest extends TestCase
{
  public function test_assert_uri(): void
  {
    $uri = new Uri('/admin/get/all');
    $this->assertEquals('Admin', $uri->controller);
    $this->assertEquals('get', $uri->method);
    $this->assertEquals('all', $uri->parameter);
  }

  #[TestDox('Uri: training/get/MAT001/post -> False')]
  public function test_exception_InvalidUri_on_the_form_uri_1(): void
  {
    $this->expectException(InvalidUri::class);
    $this->expectExceptionMessage("Url Invalida. Caraceteres maisculos e especiais nao sao permitidos");
    new Uri('training/get/MAT001/post');
  }

  #[TestDox('Uri: /training//post -> False')]
  public function test_exception_InvalidUri_on_the_form_uri_2(): void
  {
    $this->expectException(InvalidUri::class);
    $this->expectExceptionMessage("Url Invalida. Formato invalido");
    new Uri("/training//post");
  }

  #[TestDox('Uri: /training//////post -> False')]
  public function test_exception_InvalidUri_on_the_form_uri_3(): void
  {
    $this->expectException(InvalidUri::class);
    $this->expectExceptionMessage("Url Invalida. Formato invalido");
    new Uri("/training/////////post");
  }


  #[TestDox('Uri: /training/get/MAT001 -> False')]
  public function test_exception_InvalidUri_on_the_form_uri_4(): void
  {
    $this->expectException(InvalidUri::class);
    $this->expectExceptionMessage("Url Invalida. Caraceteres maisculos e especiais nao sao permitidos");
    new Uri("/training/get/MAT001");
  }

  #[TestDox('Uri: /training/get/mat001/ -> False')]
  public function test_exception_InvalidUri_on_the_form_uri_5(): void
  {
    $this->expectException(InvalidUri::class);
    $this->expectExceptionMessage("Url Invalida. Formato invalido");
    new Uri("/training/get/mat001/");
  }

  #[TestDox('Uri: /training&/*get&&&/mat001/ -> False')]
  public function test_exception_InvalidUri_on_the_form_uri_6(): void
  {
    $this->expectException(InvalidUri::class);
    $this->expectExceptionMessage("Url Invalida. Caraceteres maisculos e especiais nao sao permitidos");
    new Uri("/training&/*get&&&/mat001/");
  }

  #[TestDox('if (Uri == /), then (Controller == Home) && (Method == Null) && (Parameter == Null)')]
  public function test_assert_home(): void
  {
    $uri = new Uri('/');
    $this->assertEquals('Home', $uri->controller);
    $this->assertNull($uri->method);
    $this->assertNull($uri->parameter);
  }
}

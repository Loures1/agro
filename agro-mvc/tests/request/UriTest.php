<?php

namespace tests\request;

use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use core\uri\Server;
use core\uri\Uri;
use core\uri\exceptions\InvalidUri;

class UriTest extends TestCase
{
  #[TestDox("InvalidUri URI: training/get/MAT001")]
  public function test_expection_uri_character_upcase(): void
  {
    $_SERVER['REQUEST_URI'] = 'training/get/MAT001';
    $this->expectException(InvalidUri::class);
    $this->expectExceptionMessage(
      "Url Invalida. Caraceteres maisculos e especiais nao sao permitidos"
    );
    Uri::validade(Server::Uri);
  }

  #[TestDox("InvalidUri URI: training//post")]
  public function test_expection_uri_twice_bar(): void
  {
    $_SERVER['REQUEST_URI'] = 'training//post';
    $this->expectException(InvalidUri::class);
    $this->expectExceptionMessage("Url Invalida. Formato invalido");
    Uri::validade(Server::Uri);
  }

  #[TestDox('InvalidUri URI: /training&/*get&&&/mat001')]
  public function test_uri_final_bar(): void
  {
    $_SERVER['REQUEST_URI'] = '/training&/*get&&&/mat001';
    $this->expectException(InvalidUri::class);
    $this->expectExceptionMessage(
      "Url Invalida. Caraceteres maisculos e especiais nao sao permitidos"
    );
    Uri::validade(Server::Uri);
  }
}

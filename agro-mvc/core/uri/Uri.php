<?php

namespace core\uri;

use core\uri\exceptions\InvalidUri;

class Uri
{
  private string $controller;
  private ?string $method;
  private ?string $parameter;

  public function __construct(string $uri)
  {
    $uri = self::validadeUri($uri);
    $this->controller = ($uri[1] == true) ? ucfirst($uri[1]) : 'Home';
    $this->method = (isset($uri[2]) == true) ? $uri[2] : null;
    $this->parameter = (isset($uri[3]) == true) ? $uri[3] : null;
  }

  private function validadeUri(string $uri): ?array
  {
    if (preg_match("/[^a-zA-Z0-9\/]|[A-Z]/", $uri) == true) {
      throw new InvalidUri(
        "Url Invalida. Caraceteres maisculos e especiais nao sao permitidos"
      );
    }

    if (preg_match('/(\/{2,})/', $uri) != false || preg_match_all('/(\/\w*)/', $uri) > 3) {
      throw new InvalidUri(
        "Url Invalida. Formato invalido"
      );
    }

    $uri = explode('/', $uri);
    return $uri;
  }

  public function __get(string $name): ?string
  {
    return match ($name) {
      'controller' => $this->controller,
      'method' => $this->method,
      'parameter' => $this->parameter
    };
  }
}

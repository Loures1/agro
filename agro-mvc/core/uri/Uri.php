<?php

namespace core\uri;

use core\uri\exceptions\InvalidUri;
use core\uri\Server;
use core\uri\Method;

class Uri
{
  private string $path;
  private Method $requisition_method;
  private string $controller;
  private ?string $method;
  private ?string $parameter;

  public function __construct(Server $requisition_method, Server $uri)
  {
    $this->path = $uri->value();
    $this->requisition_method = $requisition_method->value();
    $uri = self::validadeUri($uri->value());
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

    if (
      preg_match('/(\/{2,})/', $uri) != false
      || preg_match_all('/(\/\w*)/', $uri) > 3
      || $uri == null
    ) {
      throw new InvalidUri(
        "Url Invalida. Formato invalido"
      );
    }

    $uri = explode('/', $uri);
    return $uri;
  }

  public function __get(string $name): string|Method
  {
    return match ($name) {
      'path' => $this->path,
      'requisition_method' => $this->requisition_method,
      'controller' => $this->controller,
      'method' => $this->method,
      'parameter' => $this->parameter
    };
  }
}

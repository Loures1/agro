<?php

namespace core\uri;

use core\uri\Server;
use core\uri\exceptions\InvalidUri;

class Request
{
  private Server $request_method;
  private Server $uri;
  private string $controller;
  private ?string $method;
  private ?string $parameter;

  public function __construct()
  {
    $this->request_method = Server::RequestMethod;
    $this->uri = self::validadeUri(Server::Uri);
    $this->controller = current(regex_match(
      '/(?<=^\/)[\w]+/',
      $this->uri->value(),
      fn($item) => ucfirst($item)
    ));
    $this->method = null;
    $this->parameter = null;
  }

  private function validadeUri(Server $uri): Server
  {
    if (preg_match("/[^a-zA-Z0-9\/]|[A-Z]/", $uri->value()) == true) {
      throw new InvalidUri(
        "Url Invalida. Caraceteres maisculos e especiais nao sao permitidos"
      );
    }

    if (
      preg_match('/(\/{2,})/', $uri->value()) != false
      || preg_match_all('/(\/\w*)/', $uri->value()) > 3
      || $uri == null
    ) {
      throw new InvalidUri(
        "Url Invalida. Formato invalido"
      );
    }
    return $uri;
  }
}

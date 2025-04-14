<?php

namespace core\uri;

use core\uri\Server;
use core\uri\Method;
use core\uri\Uri;

class Request
{
  private Server $request_method;
  private Server $uri;
  private ?string $controller;
  private ?string $method;
  private ?string $parameter;

  public function __construct()
  {
    $this->request_method = Server::RequestMethod;
    $this->uri = Uri::validade(Server::Uri);
    $this->controller = current(regex_match(
      '/(?<=^\/)\w+/',
      $this->uri->value(),
      fn($item) => ($item != null) ? ucfirst($item) : 'Home'
    ));
    $this->method = current(regex_match(
      '/(?<=\w\/)\w+/',
      $this->uri->value()
    ));
    $this->parameter = current(regex_match(
      '/\w+$/',
      $this->uri->value(),
      fn($item) => ($this->method != $item && $this->method != null)
        ? $item
        : null
    ));
  }

  private function paternUri(): string
  {
    if ($this->method != null && $this->parameter != null) {
      return preg_replace(
        '/\w+$/',
        '$param',
        $this->uri->value(),
      );
    }
    return $this->uri->value();
  }

  public function __get(string $name): null|string|Method
  {
    return match ($name) {
      'uri'            => self::paternUri(),
      'request_method' => $this->request_method->value(),
      'controller'     => $this->controller,
      'method'         => $this->method,
      'parameter'      => $this->parameter
    };
  }
}

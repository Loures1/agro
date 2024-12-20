<?php
include_once('config.php');

class Tokyo1
{
  protected ?string $uri;
  public ?array  $router;
  public ?array  $method;

  public function __construct()
  {
    $this->uri = $_SERVER['REQUEST_URI'];
  }

  public function __invoke()
  {
    return $this->router[$this->uri]();
  }
}

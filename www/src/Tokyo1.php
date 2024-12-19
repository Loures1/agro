<?php
include_once('config.php');

class Tokyo1
{
  public ?array $router;
  public ?string $uri;

  public function __invoke(): string
  {
    return file_get_contents(
      $this->router[$this->uri]
    );
  }
}

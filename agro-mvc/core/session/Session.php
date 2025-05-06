<?php

namespace core\session;

class Session
{
  private ?array $session;

  public function __construct()
  {
    session_start();
    $this->session = $_SESSION;
  }

  public function __get(string $name): bool
  {
    return $this->session[$name];
  }

  public function __set(string $name, string $value): void
  {
    $this->session[$name] = $value;
    $_SESSION = $this->session;
  }
}


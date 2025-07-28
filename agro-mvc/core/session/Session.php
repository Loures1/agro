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

  public function __get(string $name): bool | null
  {

    $keys = array_keys($this->session);

    if (array_search($name, $keys) === 0) {
      return $this->session[$name];
    }

    return null;
  }

  public function __set(string $name, string $value): void
  {
    $this->session[$name] = $value;
    $_SESSION = $this->session;
  }
}

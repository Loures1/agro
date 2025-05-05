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

    public function __get($name)
    {
        return $this->session[$name];
    }

    public function __set($name, $value)
    {
        $this->session[$name] = $value;
        $_SESSION = $this->session;
    }
}
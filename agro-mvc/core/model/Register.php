<?php

namespace core\model;

class Register
{
    public function __construct(private array $register) {}
    public function __get(string $name): string
    {
        return $this->register[$name];
    }
}
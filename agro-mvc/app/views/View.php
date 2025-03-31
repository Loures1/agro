<?php

namespace app\views;

abstract class View
{
    static private function render(string $path)
    {
        echo file_get_contents($path);
    }

    static public function __callStatic(string $name, $arguments)
    {
        return match ($name) {
            'render' => self::render(...$arguments)
        };
    }
}
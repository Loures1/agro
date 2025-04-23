<?php

namespace core\view;

class BodyConstructor 
{
    private string $content;

    public function __construct(string $content)
    {
        $this->content = $content;
    }

    public function __get($name)
    {
        return match($name) {
            'content' => $this->content
        };
    }
}
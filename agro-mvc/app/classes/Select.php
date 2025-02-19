<?php

namespace app\classes;

use app\classes\Query;

class Select implements Query
{
    const SYNTAX_SELECT = "SELECT fields FROM target WHERE condition";
    private ?string $target;
    private ?array $fields;
    private ?string $condition;
    private ?string $query;
    
    public function __construct($target, $fields, $condition)
    {
        $this->target = $target;
        $this->fields = $fields;
        $this->condition = $condition;
        $this->query = preg_replace(
            [
                '/fields/',
                '/target/',
                '/condition/',
            ],
            [
                implode(', ', $this->fields),
                $this->target,
                $this->condition
            ],
            self::SYNTAX_SELECT
        );

    }

    public function getTarget(): string
    {
        return $this->target;
    }

    public function getFields(): array
    {
        return $this->fields;
    }

    public function getCondition(): string
    {
        return $this->condition;
    }

    public function getQuery(): string
    {
        return $this->query;
    }
}
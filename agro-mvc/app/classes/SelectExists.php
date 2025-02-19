<?php

namespace app\classes;

class SelectExists implements Query
{
    const SYNTAX_SQL = "SELECT EXISTS (expression)";
    private ?Select $selectObj;
    private ?string $query;

    public function __construct($target, $fields, $condition)
    {
        $this->selectObj = new Select($target, $fields, $condition);
        $this->query = preg_replace(
            '/expression/',
            $this->selectObj->getQuery(),
            self::SYNTAX_SQL
        );
    }

    public function getQuery(): string
    {
        return $this->query;    
    }
}




<?php

namespace app\classes;

use app\classes\Query;
use config\Credentials;
use mysqli;

class Select implements Query
{
    const SYNTAX_SQL = "SELECT fields FROM target condition";
    private ?string $target;
    private ?array $fields;
    private ?string $condition;
    private ?string $query;
    private ?array $result;
    
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
            self::SYNTAX_SQL
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

    public function getResult(): array
    {
        return $this->result;
    }

    public function execQuery(): void
    {
        $db = new mysqli(
            hostname: Credentials::getHost(),
            username: Credentials::USERNAME,
            password: Credentials::PASSWORD,
            database: Credentials::DATABASE
        );
        $this->result = $db->query(self::getQuery())->fetch_all();
        $db->close(); 
    }
}
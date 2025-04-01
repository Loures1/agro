<?php

namespace app\classes\admin;

use app\classes\admin\Training;

class CollectionTraining 
{
    private array $trainings;

    public function __construct()
    {
        $this->trainings = [];
    }

    private function push(Training $training)
    {
        array_push($this->trainings, $training);
    }

    public function __set(string $name, Training $value)
    {
        match ($name) {
            'push' => self::push($value)
        };
    }
}

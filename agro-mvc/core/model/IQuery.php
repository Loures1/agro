<?php

namespace core\model;

interface IQuery
{
  public function match(?array $values): string;
}

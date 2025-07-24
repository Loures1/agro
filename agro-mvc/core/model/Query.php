<?php

namespace core\model;

enum Query: string
{
  case Update = "UPDATE";
  case Insert = "INSERT INTO";
  case Select = "SELECT";
  case Delete = "DELETE";

  public static function type(string $code): ?Query
  {
    foreach (self::cases() as $case) {
      if (preg_match("/{$case->value}/", $code) != false) {
        return $case;
      }
    }

    return null;
  }
}

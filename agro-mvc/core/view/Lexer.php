<?php

namespace core\view;

use core\view\exceptions\InvalidHtml;
use core\view\TypeGroup;
use core\view\Group;

class Lexer
{
  public static function createQueue(string $content, TypeGroup $type_group)
  {
    $groups = TypeGroup::getGroup($type_group);
    $expression = array_map(
      fn (Group $group) => $group->value,
      $groups
    );
    preg_match_all(
      '/' . implode('|', $expression) . '/',
      $content, 
      $matches, 
      PREG_PATTERN_ORDER + PREG_UNMATCHED_AS_NULL
    );
    $queue = [];
    foreach ($groups as $key => $group) {
      $lexem = $matches[$group->name][$key];
      if ($lexem == null) {
        throw new InvalidHtml(
          "Arquivo invalido. Falta da {$group->name}"
        );
      }
      array_push($queue, $group->ownerConstructor($lexem));
    }
    return $queue;
  }
}

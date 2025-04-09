<?php

namespace core\controller;

use core\controller\exceptions\InvalidController;
use core\controller\exceptions\ControllerDirEmpty;
use ReflectionClass;

class ExtractorControllers
{
  static public function get(string $path): ?array
  {
    $controllers = [];
    $paths = glob($path);

    if ($paths == null) {
      throw new ControllerDirEmpty(
        "Pasta '{$path}' nao a arquivos .php"
      );
    }

    foreach ($paths as $path) {
      $matches = null;
      preg_match_all(
        '/(?<=namespace\s)(.+)(?=;)|(?<=class\s)(\w+)(?=\s)/',
        file_get_contents($path),
        $matches
      );

      if ($matches == null) {
        throw new InvalidController(
          "Controller Invalido. {$path}"
        );
      }

      $controller = $matches[0][0] . '\\' . $matches[0][1];
      array_push($controllers, $controller);
    }
    return array_map(fn($controller) => new ReflectionClass(new $controller), $controllers);
  }
}

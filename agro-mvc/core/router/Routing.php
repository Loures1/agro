<?php

namespace core\router;

use ReflectionClass;
use core\controller\Controller;
use core\controller\DirController;
use core\controller\ExtractorControllers;
use core\router\exceptions\ControllerNotExist;
use core\uri\Request;
use core\uri\Server;
use core\uri\Uri;

class Routing
{
  public function __construct()
  {
    $uri = new Uri(Request::server(Server::Uri));
    $controllers = ExtractorControllers::get(DirController::Path);
    $controllers = array_map(
      fn($controller) => new ReflectionClass(new $controller),
      $controllers
    );
    $controllers = array_map(
      fn(ReflectionClass $controller): array =>
      $controller->getAttributes(Controller::class)[0]->getArguments(),
      $controllers
    );

    if (in_array($uri->controller, $controllers) == false) {
      throw new ControllerNotExist(
        "O Controller '{$uri->controller}' nao existe"
      );
    }
  }
}

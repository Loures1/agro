<?php

namespace core\router;

use ReflectionClass;
use ReflectionMethod;
use core\controller\Controller;
use core\router\Route;
use core\controller\DirController;
use core\controller\ExtractorControllers;
use core\router\exceptions\ControllerNotExist;
use core\router\exceptions\MethodNotExist;
use core\uri\Request;
use core\uri\Server;
use core\uri\Uri;

class Routing
{
  public function __construct()
  {
    dd(new Request);
    $uri = new Uri(Server::RequestMethod, Server::Uri);

    $controller = current(array_filter(
      ExtractorControllers::get(DirController::Path),
      function (ReflectionClass $controller) use ($uri) {
        $controller_name =
          $controller->getAttributes(Controller::class)[0]->getArguments()[0];
        return $controller_name == $uri->controller;
      }
    ));

    if ($controller == null) {
      throw new ControllerNotExist(
        "Controller '{$uri->controller}' nao esta definido."
      );
    }

    $method = current(array_filter(
      $controller->getMethods(),
      function (ReflectionMethod $method) use ($uri) {
        $requestion_method = 
          $method->getAttributes(Route::class)[0]->getArguments()[0];
        $path = 
          $method->getAttributes(Route::class)[0]->getArguments()[1];
        return 
          $requestion_method == $uri->requisition_method 
          && $path == $uri->path;
      }
    ));

    if ($method == null) {
      throw new MethodNotExist(
        "Nenhum metodo esta definido para '{$uri->path}'."
      );
    }
    
    $controller = $controller->getName();
    $method->invoke(new $controller, $uri->parameter);
  }
}

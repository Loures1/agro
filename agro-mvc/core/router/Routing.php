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

class Routing
{
  public function __construct()
  {
    $request = new Request;

    $controller = current(array_filter(
      ExtractorControllers::get(DirController::Path),
      function (ReflectionClass $controller) use ($request) {
        $controller_name =
          $controller->getAttributes(Controller::class)[0]->getArguments()[0];
        return $controller_name == $request->controller;
      }
    ));

    if ($controller == null) {
      throw new ControllerNotExist(
        "Controller '{$request->controller}' nao esta definido."
      );
    }

    $method = current(array_filter(
      $controller->getMethods(),
      function (ReflectionMethod $method) use ($request) {
        $requestion_method =
          $method->getAttributes(Route::class)[0]->getArguments()[0];
        $path =
          $method->getAttributes(Route::class)[0]->getArguments()[1];
        return
          $requestion_method == $request->request_method
          && $path == $request->uri;
      }
    ));

    if ($method == null) {
      throw new MethodNotExist(
        "Nenhum metodo esta definido para '{$request->uri}'."
      );
    }

    $parameter = match ($method->getAttributes(Route::class)[0]->getArguments()[2]) {
      TypeHint::Parameter => $request->parameter,
      TypeHint::File => current($_FILES),
      TypeHint::Null => null,
      TypeHint::Form => $_POST
    };

    $controller = $controller->getName();
    $method->invoke(new $controller, $parameter);
  }
}

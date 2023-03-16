<?php

namespace Cookly;

class Router
{
  private $routes = [];

  public function add(string $route, string $controller, string $action)
  {
    $this->routes[$route] = [$controller, $action];
  }

  public function run(string $route)
  {
    $route = explode("/", $route)[0];
    if (!array_key_exists($route, $this->routes)) {
      http_response_code(404);
      die();
    }

    [$controller, $action] = $this->routes[$route];
    $object = new $controller;

    $result = $object->$action();
  }

  public function test()
  {

  }
}

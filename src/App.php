<?php

namespace Cookly;

use Cookly\Database;
use Cookly\Router;

use Cookly\Controllers\HomeController;

class App
{
  public static function run()
  {
    // Create and test database connection
    Database::getInstance();

    // Create router
    $router = new Router();

    $router->add('', HomeController::class, 'home');

    $path = trim($_SERVER['REQUEST_URI'], '/');
    $path = parse_url($path, PHP_URL_PATH);

    $router->run($path);
  }
}

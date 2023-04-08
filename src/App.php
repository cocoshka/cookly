<?php

namespace Cookly;

use Cookly\Database;
use Cookly\Router;

use Cookly\Controllers\{HomeController, AuthController, ViewController, EditController};

class App
{
  public static function run()
  {
    // Create and test database connection
    Database::getInstance();

    // Create router
    $router = new Router();

    $router->add('', HomeController::class, 'explore');
    $router->add('recipes', HomeController::class, 'recipes');
    $router->add('create', EditController::class, 'create');
    $router->add('edit', EditController::class, 'edit');
    $router->add('view', ViewController::class, 'view');
    $router->add('login', AuthController::class, 'login');
    $router->add('logout', AuthController::class, 'logout');
    $router->add('signup', AuthController::class, 'signup');

    $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $path = trim($path, '/');

    $router->run($path);
  }
}

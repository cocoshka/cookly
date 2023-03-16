<?php

namespace Cookly\Controllers;

class BaseController
{
  private $request;

  public function __construct()
  {
    $this->request = $_SERVER['REQUEST_METHOD'];
  }

  protected function isGet(): bool
  {
    return $this->request === 'GET';
  }

  protected function isPost(): bool
  {
    return $this->request === 'POST';
  }

  protected function render(string $template = null, array $vars = [])
  {
    $path = '../templates/' . $template . '.php';

    if (!file_exists($path)) {
      http_response_code(404);
      die("404 Not Found");
    };

    extract($vars);
    ob_start();
    include $path;
    print ob_get_clean();
  }

  public static function redirect(string $route)
  {
    header('Location: ' . $route);
    die();
  }
}

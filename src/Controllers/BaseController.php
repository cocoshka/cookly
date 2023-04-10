<?php

namespace Cookly\Controllers;

use Cookly\Models\User;
use Cookly\Repositories\UserRepository;

class BaseController
{
  private string $request;
  private UserRepository $userRepo;

  public function __construct()
  {
    $this->request = $_SERVER['REQUEST_METHOD'];
    $this->userRepo = new UserRepository();
  }

  protected function isGet(): bool
  {
    return $this->request === 'GET';
  }

  protected function isPost(): bool
  {
    return $this->request === 'POST';
  }

  protected function isAuthenticated(): bool
  {
    return isset($_SESSION['user_id']);
  }

  protected function getCurrentUser(): ?User
  {
    $user_id = $_SESSION['user_id'];
    if (!$user_id) return null;
    return $this->userRepo->getUser($user_id);
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

  protected function redirect(string $route)
  {
    header('Location: ' . $route);
    die();
  }
}

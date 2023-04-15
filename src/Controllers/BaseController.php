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

  protected function isJson(): bool
  {
    $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
    return $contentType === "application/json";
  }

  protected function getJson(): array
  {
    $content = trim(file_get_contents("php://input"));
    return json_decode($content, true);
  }

  protected function sendJson($data)
  {
    header('Content-type: application/json');
    http_response_code(200);

    echo json_encode($data);
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
    $result = $this->execute($template, $vars);
    if (!$result) {
      http_response_code(500);
      return;
    }
    print $result;
  }

  protected function execute(string $template = null, array $vars = [])
  {
    $path = '../templates/' . $template . '.php';

    if (!file_exists($path)) {
      return false;
    };

    extract($vars);
    ob_start();
    include $path;
    return ob_get_clean();
  }

  protected function redirect(string $route)
  {
    header('Location: ' . $route);
    die();
  }
}

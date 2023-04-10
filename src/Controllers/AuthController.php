<?php

namespace Cookly\Controllers;

use Cookly\Repositories\UserRepository;

class AuthController extends BaseController
{
  private UserRepository $userRepo;

  public function __construct()
  {
    parent::__construct();
    $this->userRepo = new UserRepository();
  }

  public function logout()
  {
    session_destroy();
    $this->redirect('/login');
  }

  public function login()
  {
    if ($this->isAuthenticated()) {
      $this->redirect('/');
      return;
    }
    if ($this->isPost()) {
      $email = $_POST['email'];
      $password = $_POST['password'];

      $user_id = $this->userRepo->authenticate($email, $password);

      if (!$user_id) {
        $this->render('views/login', ['message' => "Check your email and password!"]);
        return;
      }

      $_SESSION['user_id'] = $user_id;

      $this->redirect('/');
      return;
    }
    $this->render('views/login');
  }

  public function signup()
  {
    if ($this->isAuthenticated()) {
      $this->redirect('/');
      return;
    }
    if ($this->isPost()) {
      $name = $_POST['name'];
      $email = $_POST['email'];
      $password = $_POST['password'];
      $repeat_password = $_POST['repeat_password'];

      if (!$name || !$email || !$password) {
        $this->render('views/signup', ['message' => "Fill all fields!"]);
        return;
      }

      if ($password != $repeat_password) {
        $this->render('views/signup', ['message' => "Passwords don't match!"]);
        return;
      }

      $user_id = $this->userRepo->createUser($name, $email, $password);

      if (!$user_id) {
        $this->render('views/signup', ['message' => "Unable to create user!"]);
        return;
      }

      $_SESSION['user_id'] = $user_id;

      $this->redirect('/');
      return;
    }
    $this->render('views/signup');
  }
}

<?php

namespace Cookly\Controllers;

class AuthController extends BaseController
{
  public function login()
  {
    $this->render('views/login');
  }

  public function logout()
  {
    $this->redirect('/login');
  }

  public function signup()
  {
    $this->render('views/signup');
  }
}

<?php

namespace Cookly\Controllers;

class HomeController extends BaseController
{
  public function explore()
  {
    if (!$this->isAuthenticated()) {
      $this->redirect('/login');
      return;
    }
    $user = $this->getCurrentUser();
    $this->render('views/explore', ['user' => $user]);
  }

  public function recipes()
  {
    if (!$this->isAuthenticated()) {
      $this->redirect('/login');
      return;
    }
    $user = $this->getCurrentUser();
    $this->render('views/recipes', ['user' => $user]);
  }
}

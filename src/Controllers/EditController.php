<?php

namespace Cookly\Controllers;

class EditController extends BaseController
{
  public function create()
  {
    if (!$this->isAuthenticated()) {
      $this->redirect('/login');
      return;
    }
    $user = $this->getCurrentUser();
    $this->render('views/edit', ['user' => $user]);
  }

  public function edit()
  {
    if (!$this->isAuthenticated()) {
      $this->redirect('/login');
      return;
    }
    $user = $this->getCurrentUser();
    $this->render('views/edit', ['user' => $user]);
  }
}

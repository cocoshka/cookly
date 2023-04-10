<?php

namespace Cookly\Controllers;

class ViewController extends BaseController
{
  public function view()
  {
    if (!$this->isAuthenticated()) {
      $this->redirect('/login');
      return;
    }
    $user = $this->getCurrentUser();
    $this->render('views/view', ['user' => $user]);
  }
}

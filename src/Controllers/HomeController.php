<?php

namespace Cookly\Controllers;

class HomeController extends BaseController
{
  public function home()
  {
    $this->render('views/home');
  }
}

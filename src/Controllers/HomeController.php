<?php

namespace Cookly\Controllers;

class HomeController extends BaseController
{
  public function explore()
  {
    $this->render('views/explore');
  }

  public function recipes()
  {
    $this->render('views/recipes');
  }
}

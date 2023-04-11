<?php

namespace Cookly\Controllers;

use Cookly\Repositories\RecipeRepository;

class HomeController extends BaseController
{
  private RecipeRepository $recipeRepo;

  public function __construct()
  {
    parent::__construct();
    $this->recipeRepo = new RecipeRepository();
  }

  public function explore()
  {
    if (!$this->isAuthenticated()) {
      $this->redirect('/login');
      return;
    }
    $user = $this->getCurrentUser();
    $recipes = $this->recipeRepo->getPublicRecipes();
    $this->render('views/list', ['user' => $user, 'title' => 'Explore', 'recipes' => $recipes]);
  }

  public function recipes()
  {
    if (!$this->isAuthenticated()) {
      $this->redirect('/login');
      return;
    }
    $user = $this->getCurrentUser();
    $recipes = $this->recipeRepo->getUserRecipes($user->getId());
    $this->render('views/list', ['user' => $user, 'title' => 'Your recipes', 'recipes' => $recipes]);
  }
}

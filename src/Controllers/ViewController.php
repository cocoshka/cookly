<?php

namespace Cookly\Controllers;

use Cookly\Repositories\RecipeRepository;
use Cookly\Repositories\UserRepository;

class ViewController extends BaseController
{
  private RecipeRepository $recipeRepo;
  private UserRepository $userRepo;

  public function __construct()
  {
    parent::__construct();
    $this->recipeRepo = new RecipeRepository();
    $this->userRepo = new UserRepository();
  }

  public function view()
  {
    if (!$this->isAuthenticated()) {
      $this->redirect('/login');
      return;
    }
    $user = $this->getCurrentUser();

    $recipe_id = $_GET['id'] ?? null;

    if (!$recipe_id) {
      http_response_code(404);
      return;
    }

    $recipe = $this->recipeRepo->getRecipe($recipe_id);
    $author = $this->userRepo->getUser($recipe->getUserId());

    $isAuthor = $user->getId() == $author->getId();

    if (!$recipe->isPublic() && !$isAuthor) {
      http_response_code(403);
      return;
    }

    $userRating = $this->recipeRepo->getRecipeUserRating($recipe->getId(), $user->getId());

    $this->render('views/view', [
      'user' => $user,
      'recipe' => $recipe,
      'author' => $author,
      'userRating' => $userRating,
      'canEdit' => $isAuthor,
      'canPublish' => !$recipe->isPublic() && $isAuthor && $user->hasPermission("recipe.publish"),
      'canUnpublish' => $recipe->isPublic() && ($isAuthor || $user->hasPermission("recipe.unpublish")),
      'canDelete' => $isAuthor || $user->hasPermission("recipe.delete"),
      'canRate' => !$isAuthor,
    ]);
  }

  public function rate()
  {
    if (!$this->isAuthenticated()) {
      http_response_code(401);
      return;
    }
    $user = $this->getCurrentUser();

    if (!$this->isPost()) {
      http_response_code(400);
      return;
    }

    if (!$this->isJson()) {
      http_response_code(400);
      return;
    }

    $json = $this->getJson();

    $id = $json['id'] ?? null;
    $stars = $json['stars'] ?? null;

    if (!$id || !$stars) {
      http_response_code(400);
      return;
    }

    $recipe = $this->recipeRepo->getRecipe($id);

    if (!$recipe) {
      http_response_code(404);
      return;
    }

    $isAuthor = $user->getId() === $recipe->getUserId();

    if ($isAuthor) {
      http_response_code(403);
      return;
    }

    $result = $this->recipeRepo->rateRecipe($recipe->getId(), $user->getId(), $stars);
    if (!$result) {
      http_response_code(500);
    }

    $rating = $this->recipeRepo->getRecipeRating($recipe->getId());

    $templates = [
      'rating' => $rating,
      'userRating' => $stars,
    ];

    $this->sendJson($templates);
  }

  public function publish()
  {
    if (!$this->isAuthenticated()) {
      $this->redirect('/login');
      return;
    }
    $user = $this->getCurrentUser();

    $id = $_REQUEST['id'];
    $recipe = $this->recipeRepo->getRecipe($id);

    if (!$recipe) {
      http_response_code(404);
      return;
    }

    $isAuthor = $user->getId() === $recipe->getUserId();

    if (!$isAuthor || !$user->hasPermission("recipe.publish")) {
      http_response_code(403);
      return;
    }

    $result = $this->recipeRepo->publishRecipe($recipe->getId());
    if (!$result) {
      http_response_code(500);
      return;
    }

    $this->redirect("/view?id=" . $recipe->getId());
  }

  public function unpublish()
  {
    if (!$this->isAuthenticated()) {
      $this->redirect('/login');
      return;
    }
    $user = $this->getCurrentUser();

    $id = $_REQUEST['id'];
    $recipe = $this->recipeRepo->getRecipe($id);

    if (!$recipe) {
      http_response_code(404);
      return;
    }

    $isAuthor = $user->getId() === $recipe->getUserId();

    if (!$isAuthor && !$user->hasPermission("recipe.unpublish")) {
      http_response_code(403);
      return;
    }

    $result = $this->recipeRepo->unpublishRecipe($recipe->getId());
    if (!$result) {
      http_response_code(500);
      return;
    }

    if ($isAuthor) {
      $this->redirect("/view?id=" . $recipe->getId());
    } else {
      $this->redirect("/");
    }
  }

  public function delete()
  {
    if (!$this->isAuthenticated()) {
      $this->redirect('/login');
      return;
    }
    $user = $this->getCurrentUser();

    $id = $_REQUEST['id'];
    $recipe = $this->recipeRepo->getRecipe($id);

    if (!$recipe) {
      http_response_code(404);
      return;
    }

    if ($user->getId() !== $recipe->getUserId() && !$user->hasPermission("recipe.delete")) {
      http_response_code(403);
      return;
    }

    $result = $this->recipeRepo->deleteRecipe($recipe->getId());
    if (!$result) {
      http_response_code(500);
      return;
    }

    $this->redirect("/");
  }
}

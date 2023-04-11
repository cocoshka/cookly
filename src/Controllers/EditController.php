<?php

namespace Cookly\Controllers;

use Cookly\Constants;
use Cookly\Repositories\RecipeRepository;

class EditController extends BaseController
{
  private RecipeRepository $recipeRepo;

  public function __construct()
  {
    parent::__construct();
    $this->recipeRepo = new RecipeRepository();
  }

  public function create()
  {
    if (!$this->isAuthenticated()) {
      $this->redirect('/login');
      return;
    }
    $user = $this->getCurrentUser();
    if ($this->isPost()) {
      $name = $_POST['name'];
      $details = $_POST['details'];
      $file = $_FILES['image'] ?? null;
      $filename = $file['tmp_name'] ?? null;

      if (!$name || !$filename || !is_uploaded_file($filename)) {
        $this->render('views/edit', [
          'user' => $user,
          'name' => $name,
          'details' => $details,
          'message' => "Recipe name and image are required!"
        ]);
        return;
      }

      if (!$this->validateImage($file)) {
        $this->render('views/edit', [
          'user' => $user,
          'name' => $name,
          'details' => $details,
          'message' => "Uploaded file is not an image!"
        ]);
        return;
      }

      $image = file_get_contents($filename);

      if (!$image) {
        $this->render('views/edit', [
          'user' => $user,
          'name' => $name,
          'details' => $details,
          'message' => "Unable to read image!"
        ]);
        return;
      }

      $recipe_id = $this->recipeRepo->createRecipe(
        $user->getId(),
        $name,
        $details,
        $image
      );

      if (!$recipe_id) {
        $this->render('views/edit', [
          'user' => $user,
          'name' => $name,
          'details' => $details,
          'message' => "Unable to create recipe!"
        ]);
        return;
      }

      $this->redirect('/recipes');
      return;
    }

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

  private function validateImage($file): bool
  {
    $fileInfo = new \finfo(FILEINFO_MIME_TYPE);
    $mimeType = $fileInfo->file($file['tmp_name']);
    return in_array($mimeType, Constants::SUPPORTED_IMAGE_TYPES);
  }
}

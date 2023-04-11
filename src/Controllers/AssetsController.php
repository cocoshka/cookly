<?php

namespace Cookly\Controllers;

use Cookly\Repositories\RecipeRepository;

class AssetsController extends BaseController
{
  private RecipeRepository $recipeRepo;

  public function __construct()
  {
    parent::__construct();
    $this->recipeRepo = new RecipeRepository();
  }

  public function image()
  {
    $recipe_id = $_GET['id'] ?? null;
    if (!$recipe_id) {
      http_response_code(404);
      return;
    }

    $image = $this->recipeRepo->getRecipeImage($recipe_id);

    if (!$image) {
      http_response_code(404);
      return;
    }

    $fileInfo = new \finfo(FILEINFO_MIME_TYPE);
    $mimeType = $fileInfo->buffer($image);

    header("Content-Type: $mimeType");
    echo $image;
  }
}

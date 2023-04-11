<?php

namespace Cookly\Repositories;

use Cookly\Models\Recipe;

class RecipeRepository extends Repository
{
  public function getPublicRecipes(): array
  {
    $stmt = $this->db->prepare('SELECT r.id, r.user_id, uv.name AS user_name, r.name, r.details, r.is_public FROM public.recipe AS r JOIN public.user_view uv on uv.id = r.user_id WHERE r.is_public = TRUE');
    $stmt->execute();

    $recipes = $stmt->fetchAll(\PDO::FETCH_ASSOC);

    return $this->toRecipeArray($recipes);
  }

  public function getUserRecipes(int $user_id): array
  {
    $stmt = $this->db->prepare('SELECT r.id, r.user_id, uv.name AS user_name, r.name, r.details, r.is_public FROM public.recipe AS r JOIN public.user_view uv on uv.id = r.user_id WHERE r.user_id = :user_id');
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();

    $recipes = $stmt->fetchAll(\PDO::FETCH_ASSOC);

    return $this->toRecipeArray($recipes);
  }

  public function getRecipeRating(int $recipe_id): float
  {
    $stmt = $this->db->prepare('SELECT rs.rating FROM public.recipe_stars AS rs  WHERE rs.recipe_id = :recipe_id');
    $stmt->bindParam(':recipe_id', $recipe_id);
    $stmt->execute();

    $ratings = $stmt->fetchAll(\PDO::FETCH_COLUMN);

    if (!$ratings) {
      return 0;
    }

    return array_sum($ratings) / count($ratings);
  }

  public function getRecipeImage(int $recipe_id)
  {
    $stmt = $this->db->prepare('SELECT r.image FROM public.recipe AS r WHERE r.id = :recipe_id LIMIT 1');
    $stmt->bindParam(':recipe_id', $recipe_id);
    $stmt->execute();

    $image = $stmt->fetch(\PDO::FETCH_COLUMN);

    if (!$image) {
      return null;
    }

    return stream_get_contents($image);
  }

  public function createRecipe(
    int    $user_id,
    string $name,
    string $details,
    string $image
  ): ?int
  {
    $stmt = $this->db->prepare('INSERT INTO public.recipe (user_id, name, image, details) VALUES (:user_id, :name, :image, :details) RETURNING id');
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':details', $details);
    $stmt->bindParam(':image', $image, \PDO::PARAM_LOB);
    $stmt->execute();

    $recipe_id = $stmt->fetchColumn();

    if (!$recipe_id) {
      return null;
    }

    return $recipe_id;
  }

  private function toRecipe($recipe): Recipe
  {
    $stars = $this->getRecipeRating($recipe['id']);

    return new Recipe(
      $recipe['id'],
      $recipe['user_id'],
      $recipe['user_name'],
      $recipe['name'],
      $recipe['details'],
      $recipe['is_public'],
      $stars
    );
  }

  private function toRecipeArray($recipes): array
  {
    $result = [];

    if (!!$recipes) {
      foreach ($recipes as $recipe) {
        $result[] = $this->toRecipe($recipe);
      }
    }

    return $result;
  }
}

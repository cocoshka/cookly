<?php

namespace Cookly\Repositories;

use Cookly\Models\Recipe;

class RecipeRepository extends Repository
{
  const SEARCH_QUERY = ' AND r.search @@ to_tsquery(:search)';

  public function deleteRecipe(int $recipe_id): bool
  {
    $stmt = $this->db->prepare('DELETE FROM public.recipe AS r WHERE r.id = :recipe_id');
    $stmt->bindParam(":recipe_id", $recipe_id);

    return $stmt->execute();
  }

  public function rateRecipe(int $recipe_id, int $user_id, int $stars): bool
  {
    $stars = max(1, min($stars, 5));

    $stmt = $this->db->prepare('INSERT INTO public.recipe_stars (recipe_id, user_id, rating) VALUES (:recipe_id, :user_id, :stars) ON CONFLICT (recipe_id, user_id) DO UPDATE SET rating = :stars;');
    $stmt->bindParam(":recipe_id", $recipe_id);
    $stmt->bindParam(":user_id", $user_id);
    $stmt->bindParam(":stars", $stars);

    return $stmt->execute();
  }

  public function updateRecipe(
    int    $recipe_id,
    int    $user_id,
    string $name,
    string $details,
    string $image
  ): bool
  {
    $stmt = $this->db->prepare('UPDATE public.recipe AS r SET user_id = :user_id, name = :name, image = :image, details = :details WHERE r.id = :recipe_id');
    $stmt->bindParam(":recipe_id", $recipe_id);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':details', $details);
    $stmt->bindParam(':image', $image, \PDO::PARAM_LOB);

    return $stmt->execute();
  }

  public function publishRecipe(
    int $recipe_id
  ): bool
  {
    $stmt = $this->db->prepare('UPDATE public.recipe AS r SET is_public = TRUE WHERE r.id = :recipe_id');
    $stmt->bindParam(":recipe_id", $recipe_id);

    return $stmt->execute();
  }

  public function unpublishRecipe(
    int $recipe_id
  ): bool
  {
    $stmt = $this->db->prepare('UPDATE public.recipe AS r SET is_public = FALSE WHERE r.id = :recipe_id');
    $stmt->bindParam(":recipe_id", $recipe_id);

    return $stmt->execute();
  }


  public function getRecipe(int $recipe_id): Recipe
  {
    $stmt = $this->db->prepare('SELECT r.id, r.user_id, uv.name AS user_name, r.name, r.details, r.is_public FROM public.recipe AS r JOIN public.user_view uv on uv.id = r.user_id WHERE r.id = :recipe_id');
    $stmt->bindParam(":recipe_id", $recipe_id);
    $stmt->execute();

    $recipe = $stmt->fetch(\PDO::FETCH_ASSOC);

    return $this->toRecipe($recipe);
  }

  public function getPublicRecipes(?string $search): array
  {
    $query = 'SELECT r.id, r.user_id, uv.name AS user_name, r.name, r.details, r.is_public FROM public.recipe AS r JOIN public.user_view uv on uv.id = r.user_id WHERE r.is_public = TRUE';
    if ($search) {
      $query .= self::SEARCH_QUERY;
    }
    $stmt = $this->db->prepare($query);
    if ($search) {
      $stmt->bindParam(':search', $search);
    }
    $stmt->execute();

    $recipes = $stmt->fetchAll(\PDO::FETCH_ASSOC);

    return $this->toRecipeArray($recipes);
  }

  public function getUserRecipes(int $user_id, ?string $search): array
  {
    $query = 'SELECT r.id, r.user_id, uv.name AS user_name, r.name, r.details, r.is_public FROM public.recipe AS r JOIN public.user_view uv on uv.id = r.user_id WHERE r.user_id = :user_id';
    if ($search) {
      $query .= self::SEARCH_QUERY;
    }
    $stmt = $this->db->prepare($query);
    $stmt->bindParam(':user_id', $user_id);
    if ($search) {
      $stmt->bindParam(':search', $search);
    }
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

  public function getRecipeUserRating(int $recipe_id, int $user_id): float
  {
    $stmt = $this->db->prepare('SELECT rs.rating FROM public.recipe_stars AS rs WHERE rs.recipe_id = :recipe_id AND rs.user_id = :user_id LIMIT 1');
    $stmt->bindParam(':recipe_id', $recipe_id);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();

    $rating = $stmt->fetch(\PDO::FETCH_COLUMN);

    if (!$rating) {
      return 0;
    }

    return $rating;
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

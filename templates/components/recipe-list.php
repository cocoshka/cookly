<?php

function createRecipeList(array $recipes)
{
  foreach ($recipes as $recipe) {
    $id = $recipe->getId();
    $name = $recipe->getName();
    $user_name = $recipe->getUserName();
    $stars = $recipe->getStars();
    ?>

    <a class="recipe-card" href="/view?id=<?= $id ?>">
      <div class="recipe-card__thumbnail">
        <img src="/image?id=<?= $id ?>">
      </div>
      <div class="recipe-card__content">
        <div class="h2"><?= $name ?></div>
        <?php createStars($stars); ?>
        <div class="recipe-card__author"><?= $user_name ?></div>
      </div>
    </a>

    <?php
  }
}

?>

<?php require_once(__DIR__."/../components/stars.php") ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php include(__DIR__."/../common/head.php") ?>

  <title>Cookly</title>
</head>

<body>
  <div class="container">
    <?php include(__DIR__."/../common/header.php") ?>
    <main class="main">
      <div class="top-bar">
        <div class="page-title h1">Your recipes</div>
        <?php include(__DIR__."/../components/search.php") ?>
      </div>
      <div class="recipes">
        <a class="recipe-card" href="/view?id=1">
          <div class="recipe-card__thumbnail">
            <img src="/assets/meal.jpg">
          </div>
          <div class="recipe-card__content">
            <div class="h2">Grilled Pork Tenderloin with Orange Marmalade Glaze</div>
            <?php createStars(4.35);?>
            <div class="recipe-card__author">Marcin Kokoszka</div>
          </div>
        </a>
        <a class="recipe-card" href="/view?id=2">
          <div class="recipe-card__thumbnail">
            <img src="/assets/meal.jpg">
          </div>
          <div class="recipe-card__content">
            <div class="h2">Grilled Pork Tenderloin with Orange Marmalade Glaze</div>
            <?php createStars(4.35);?>
            <div class="recipe-card__author">Marcin Kokoszka</div>
          </div>
        </a>
        <a class="recipe-card" href="/view?id=3">
          <div class="recipe-card__thumbnail">
            <img src="/assets/meal.jpg">
          </div>
          <div class="recipe-card__content">
            <div class="h2">Grilled Pork Tenderloin with Orange Marmalade Glaze</div>
            <?php createStars(4.35);?>
            <div class="recipe-card__author">Marcin Kokoszka</div>
          </div>
        </a>
        <a class="recipe-card" href="/view?id=4">
          <div class="recipe-card__thumbnail">
            <img src="/assets/meal.jpg">
          </div>
          <div class="recipe-card__content">
            <div class="h2">Grilled Pork Tenderloin with Orange Marmalade Glaze</div>
            <?php createStars(4.35);?>
            <div class="recipe-card__author">Marcin Kokoszka</div>
          </div>
        </a>
      </div>
    </main>
  </div>

  <?php include(__DIR__."/../common/scripts.php") ?>
</body>

</html>

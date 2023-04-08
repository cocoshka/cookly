<?php include(__DIR__."/../components/stars.php") ?>

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
        <div class="top-bar top-bar--column">
          <div class="page-title h1">Grilled Pork Tenderloin with Orange Marmalade Glaze</div>
          <div class="recipe-actions">
            <?php createStars(3.23) ?>
            <div class="button button--menu">
              <i class="fa-solid fa-ellipsis"></i>
              <div class="button-menu">
                <button class="button"><i class="fa-solid fa-pen"></i> Edit</button>
                <button class="button"><i class="fa-solid fa-eye"></i> Publish</button>
                <button class="button"><i class="fa-solid fa-xmark"></i> Delete</button>
              </div>
            </div>
          </div>
        </div>
      <div class="recipe-details">
        <img class="recipe-details__image" src="/assets/meal.jpg">
        <div class="account">
          <img class="avatar" src="/assets/avatar.png">
          <div class="username">Marcin Kokoszka</div>
          <div class="role">Administrator</div>
        </div>
        <div class="recipe-details__recipe">
          <div id="recipe-content" class="recipe-details__content"></div>
        </div>
      </div>
    </main>
  </div>

  <?php include(__DIR__."/../common/scripts.php") ?>
</body>

</html>

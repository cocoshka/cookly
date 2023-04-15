<?php include(__DIR__ . "/../components/stars.php") ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php include(__DIR__ . "/../common/head.php") ?>

  <title>Cookly</title>
</head>

<body>
<div class="container">
  <?php include(__DIR__ . "/../common/header.php") ?>
  <main class="main">
    <div class="top-bar top-bar--column">
      <div class="page-title h1"><?= $recipe->getName() ?></div>
      <div class="recipe-actions">
        <div class="stars-rate">
          <?php createStars($recipe->getStars()) ?>
        </div>
        <?php if ($canEdit || $canPublish || $canUnpublish || $canDelete) { ?>
          <div class="button button--menu">
            <i class="fa-solid fa-ellipsis"></i>
            <div class="button-menu">
              <?php
              if ($canEdit) { ?>
                <a class="button" href="/edit?id=<?= $recipe->getId() ?>"><i class="fa-solid fa-pen"></i> Edit</a>
              <?php } ?>
              <?php
              if ($canPublish) { ?>
                <a class="button" href="/publish?id=<?= $recipe->getId() ?>"><i class="fa-solid fa-eye"></i> Publish</a>
              <?php } ?>
              <?php
              if ($canUnpublish) { ?>
                <a class="button" href="/unpublish?id=<?= $recipe->getId() ?>"><i class="fa-solid fa-eye-slash"></i>
                  Unpublish</a>
              <?php } ?>
              <?php
              if ($canDelete) { ?>
                <a class="button" href="/delete?id=<?= $recipe->getId() ?>"><i class="fa-solid fa-xmark"></i> Delete</a>
              <?php } ?>
            </div>
          </div>
        <?php } ?>
      </div>
    </div>
    <div class="recipe-details">
      <img class="recipe-details__image" src="/image?id=<?= $recipe->getId() ?>">
      <div class="account">
        <div class="avatar">
          <img src="/assets/avatar.png">
        </div>
        <div class="username"><?= $author->getName() ?></div>
        <div class="role"><?= $author->getRoleName() ?></div>
      </div>
      <div class="recipe-details__recipe">
        <div id="recipe-content" class="recipe-details__content markdown-body"
             data-md="<?= htmlspecialchars($recipe->getDetails() ?? '') ?>"></div>
      </div>
      <?php if ($canRate) { ?>
        <hr>
        <div class="rate-section">
          <span class="h2">Did this recipe delight your taste buds?</span>
          <div id="stars-rate">
            <?php createStars($userRating) ?>
          </div>
        </div>
      <?php } ?>
    </div>
  </main>
</div>

<?php include(__DIR__ . "/../common/scripts.php") ?>
</body>

</html>

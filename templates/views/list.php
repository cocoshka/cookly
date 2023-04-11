<?php require_once(__DIR__ . "/../components/stars.php") ?>
<?php require_once(__DIR__ . "/../components/recipe-list.php") ?>

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
    <div class="top-bar">
      <div class="page-title h1"><?= $title ?></div>
      <?php include(__DIR__ . "/../components/search.php") ?>
    </div>
    <div class="recipes">
      <?= createRecipeList($recipes) ?>
    </div>
  </main>
</div>

<?php include(__DIR__ . "/../common/scripts.php") ?>
</body>

</html>

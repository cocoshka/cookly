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
    </div>
    <form class="editor" method="post" enctype="multipart/form-data">
      <input type="hidden" name="id" value="<?= htmlspecialchars($id ?? '') ?>">
      <label class="form-item">
        <div class="form-item__label">Recipe name</div>
        <div class="input">
          <input class="form-item__input" type="text" name="name" required
                 value="<?= htmlspecialchars($name ?? '') ?>"/>
        </div>
      </label>
      <label class="form-item">
        <div class="form-item__label">Image</div>
        <div class="input">
          <input class="form-item__input" type="file" name="image"
                 accept="image/png, image/jpeg" <?= !isset($id) ? "required" : '' ?>/>
        </div>
      </label>
      <div class="form-item">
        <div class="form-item__label">Details</div>
        <div class="form-item__space radio-group">
          <input class="radio" id="radio-markdown" type="radio" name="preview" value="0" checked/>
          <label class="radio__label" for="radio-markdown">Markdown</label>
          <input class="radio" id="radio-preview" type="radio" name="preview" value="1"/>
          <label class="radio__label" for="radio-preview">Preview</label>
        </div>
        <label class="input input--textarea">
          <div id="details-preview" class="details-preview markdown-body"></div>
          <div class="grow-wrap" data-replicated-value="<?= htmlspecialchars($details ?? '') ?>">
            <textarea id="details-markdown" name="details"
                      oninput="this.parentNode.dataset.replicatedValue = this.value"><?= htmlspecialchars($details ?? '') ?></textarea>
          </div>
        </label>
      </div>
      <div class="message message--error">
        <?= $message ?? '' ?>
      </div>
      <input class="button button--primary button--fill" type="submit" value="Submit"/>
    </form>
  </main>
</div>

<?php include(__DIR__ . "/../common/scripts.php") ?>
</body>

</html>

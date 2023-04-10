<!DOCTYPE html>
<html lang="en">

<head>
  <?php include(__DIR__."/../common/head.php") ?>

  <title>Cookly</title>
</head>

<body>
  <div class="auth-container">
    <img class="logo" src="../assets/cookly.svg">
    <div class="auth-box">
      <div class="auth-spacer"></div>
      <form method="post" class="auth-form">
        <div class="auth-title">
          Log In
        </div>
        <div class="auth-caption">
          Are you hungry? Let's find out what you'll cook today!
        </div>
        <label class="form-item">
          <div class="form-item__label">Email</div> 
          <div class="input">
            <input class="form-item__input" type="email" name="email" />
          </div>
        </label>

        <label class="form-item">
          <div class="form-item__label">Password</div> 
          <div class="input">
            <input class="form-item__input" type="password" name="password" />
          </div>
        </label>

        <div class="auth-message message message--error">
          <?= $message ?? '' ?>
        </div>
        
        <input class="button button--primary button--fill" type="submit" value="Let's cook" />
      </form>
      <div class="signup-link">
        Don't have an account?
        <a class="link" href="/signup">
          Sign Up
        </a>
      </div>
    </div>
  </div>
</body>

</html>

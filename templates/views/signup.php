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
          Sign Up
        </div>
        <div class="auth-caption">
          Don't have your recipes yet? Find available recipes or create your own!
        </div>

        <label class="form-item">
          <div class="form-item__label">Name</div> 
          <div class="input">
            <input class="form-item__input" type="text" name="name" />
          </div>
        </label>

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

        <label class="form-item">
          <div class="form-item__label">Repeat password</div> 
          <div class="input">
            <input class="form-item__input" type="password" name="repeat_password" />
          </div>
        </label>
        
        <input class="button button--primary button--fill" type="submit" value="Let's explore" />
      </form>
      <div class="signup-link">
        Already have an account?
        <a class="link" href="/login">
          Log In
        </a>
      </div>
    </div>
  </div>
</body>

</html>

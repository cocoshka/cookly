<?php
function isRouteActive($path): ?string
{
  global $route;
  return $route == $path ? 'active' : null;
}

?>

<div class="panel">
  <header class="header">
    <img class="logo" src="../assets/cookly.svg" alt="Cookly logo">
    <button class="menu-toggle button">
      <i class="menu-open-icon fa-solid fa-bars"></i>
      <i class="menu-close-icon fa-solid fa-xmark"></i>
    </button>
  </header>
  <div class="menu">
    <nav class="nav">
      <ul class="list">
        <li class="<?= isRouteActive('') ?>">
          <a href="/">
            <i class="list-icon fa-solid fa-globe"></i>
            Explore
          </a>
        </li>
        <li class="<?= isRouteActive('create') ?>">
          <a href="/create">
            <i class="list-icon fa-solid fa-scroll"></i>
            Create
          </a>
        </li>
        <li class="<?= isRouteActive('recipes') ?>">
          <a href="/recipes">
            <i class="list-icon fa-solid fa-book"></i>
            Your recipes
          </a>
        </li>
      </ul>
    </nav>
    <div class="profile">
      <div class="account">
        <div class="avatar">
          <img src="/assets/avatar.png">
        </div>
        <div class="username"><?= $user->getName() ?></div>
        <div class="role"><?= $user->getRoleName() ?></div>
      </div>
      <ul class="list">
        <li>
          <a href="/logout">
            <i class="list-icon fa-solid fa-lock"></i>
            Logout
          </a>
        </li>
      </ul>
    </div>
  </div>
</div>

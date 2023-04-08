<?php
function createStars($rate, $max = 5) {
  $rate ??= 0;
  $stars = round($rate * 2) / 2;
  $full_stars = floor($stars);
  $empty_stars = $max - ceil($stars);
  $half_stars = $max - $full_stars - $empty_stars
  ?>

  <div class="stars">
    <?php for ($i = 0; $i < $full_stars; $i++) { ?>
      <i class="fa-solid fa-star"></i>
    <?php } ?>
    <?php for ($i = 0; $i < $half_stars; $i++) { ?>
      <i class="fa-solid fa-star-half-stroke"></i>
    <?php } ?>
    <?php for ($i = 0; $i < $empty_stars; $i++) { ?>
      <i class="fa-regular fa-star"></i>
    <?php } ?>
  </div>

<?php } ?>


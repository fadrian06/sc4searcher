<?php if (isset($_SESSION['user'])): ?>
  <h1>Bienvenid@ <?= $_SESSION['user']['username'] ?></h1>
<?php endif ?>

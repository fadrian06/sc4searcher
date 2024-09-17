<?php

use SC4S\Models\Modder;

/** @var Modder[] $modders */

?>

<section>
  <h1>Modders</h1>
  <ul>
    <?php foreach ($modders as $modder): ?>
      <li>
        <a href="./modders/<?= $modder->name ?>">
          <img src="<?= $modder->profileImageLink ?>" />
          <?= $modder->name ?>
        </a>
        <a href="./modders/<?= $modder->name ?>/eliminar" role="button">Eliminar</a>
      </li>
    <?php endforeach ?>
  </ul>
</section>

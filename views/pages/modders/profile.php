<?php

use SC4S\Models\Modder;

/** @var Modder $modder */

?>

<h1><?= $modder->name ?></h1>
<a
  href="<?= $modder->profileLink ?>?do=content&type=downloads_file&change_section=1"
  target="_blank">
  Ver perfil en Simtropolis
</a>

<section>
  <?php if ($modder->hasPlugins()): ?>
  <?php else: ?>
    No hay plugins asociados
  <?php endif ?>
</section>

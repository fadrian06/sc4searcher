<?php

use SC4S\Models\Modder;

/** @var Modder $modder */

?>

<h1>
  <img src="<?= $modder->profileImageLink ?>" />
  <?= $modder->name ?>
</h1>
<a
  href="<?= $modder->profileLink ?>?do=content&type=downloads_file&change_section=1"
  target="_blank">
  Ver perfil en Simtropolis
</a>

<section>
  <?php if ($modder->hasPlugins()): ?>
    <?php foreach ($modder->getPlugins() as $plugin): ?>
      <li>
        <a
          href="<?= $plugin->downloadPageLink ?>"
          target="_blank">
          <img src="<?= @$plugin->imagesLinks[0] ?>" />
          <?= $plugin->name ?>
        </a>
        <?php if ($plugin->hasDependencies()): ?>
          <ul>
            <li>Dependencies</li>
            <?php foreach ($plugin->dependencies as $dependency): ?>
              <li>
                <a
                  href="<?= $dependency->downloadPageLink ?>"
                  target="_blank">
                  <?= $dependency->name ?>
                </a>
              </li>
            <?php endforeach ?>
          </ul>
        <?php endif ?>
      </li>
    <?php endforeach ?>
  <?php else: ?>
    No hay plugins asociados
  <?php endif ?>
</section>

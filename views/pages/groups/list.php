<?php

use SC4S\Models\Group;

/** @var Group[] $groups */

?>

<section>
  <h1>Grupos</h1>
  <ul>
    <?php foreach ($groups as $group): ?>
      <li>
        <?php if (file_exists(ROOT . "/translations/groups/$group->name.json")): ?>
          <abbr
            title="<?= json_decode(file_get_contents(ROOT . "/translations/groups/$group->name.json"))->{$_SESSION['configs']['language'] ?? 'en'} ?>">
            <?= $group->name ?>
          </abbr>
        <?php else: ?>
          <?= $group->name ?>
        <?php endif ?>
      </li>
    <?php endforeach ?>
  </ul>
</section>

<section>
  <h2>Registrar grupo</h2>
  <form method="post">
    <input name="name" placeholder="Nombre" required />
    <button type="submit">Registrar</button>
  </form>
</section>

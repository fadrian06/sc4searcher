<?php

use SC4S\Models\Group;

/** @var Group[] $groups */

function getTranslation(Group $group): ?string
{
  $filePath = ROOT . "/translations/groups/$group->name.json";

  if (file_exists($filePath)) {
    $fileContents = file_get_contents($filePath);
    $translations = json_decode($fileContents);

    if (property_exists($translations, $_SESSION['configuration']['language']->value)) {
      return $translations->{$_SESSION['configuration']['language']->value};
    }
  }

  return null;
}

?>

<section>
  <h1>Grupos</h1>
  <ul>
    <?php foreach ($groups as $group): ?>
      <li>
        <abbr
          title="<?= getTranslation($group) ?>">
          <?= $group->name ?>
        </abbr>
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

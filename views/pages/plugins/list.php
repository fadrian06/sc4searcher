<?php

use SC4S\Models\Category;
use SC4S\Models\Group;
use SC4S\Models\Modder;
use SC4S\Models\Plugin;

/**
 * @var Modder[] $modders
 * @var Category[] $categories
 * @var Plugin[] $plugins
 * @var Group[] $groups
 */

/** @return object{name: string} */
function getTranslation(Plugin $plugin): object
{
  $filePath = ROOT . "/translations/plugins/$plugin->id.json";

  if (file_exists($filePath)) {
    $fileContents = file_get_contents($filePath);
    $translations = json_decode($fileContents);

    if (property_exists($translations, $_SESSION['configuration']['language']->value)) {
      return $translations->{$_SESSION['configuration']['language']->value};
    }
  }

  return $plugin;
}

?>

<section>
  <h1>Plugins</h1>
  <ul>
    <?php foreach ($plugins as $plugin): ?>
      <li>
        <a
          href="<?= $plugin->downloadPageLink ?>"
          target="_blank">
          <img src="<?= @$plugin->imagesLinks[0] ?>" />
          <?= getTranslation($plugin)->name ?>
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
  </ul>
</section>

<section>
  <h2>Registrar plugin</h2>
  <form method="post">
    <input name="name" placeholder="Nombre" required />
    <input
      type="url"
      name="link"
      placeholder="Enlace"
      required
      pattern="https://.+" />
    <input
      name="version"
      placeholder="Versión"
      required
      pattern="\d+(.\d+(.\d+)?)?" />
    <label>
      Fecha de primera publicación:
      <input type="date" name="submitted" required />
    </label>
    <label>
      Fecha de última actualización:
      <input type="date" name="updated" required />
    </label>
    <textarea name="description" placeholder="Descripción"></textarea>
    <textarea name="installation" placeholder="Instalación" required></textarea>
    <textarea name="desinstallation" placeholder="Desinstalación" required></textarea>
    <select name="modder" required>
      <option value="">Selecciona un modder</option>
      <?php foreach ($modders as $modder): ?>
        <option><?= $modder->name ?></option>
      <?php endforeach ?>
    </select>
    <select name="category" required>
      <option value="">Selecciona una categoría</option>
      <?php foreach ($categories as $category): ?>
        <?php if ($category->isSubcategory()): ?>
          <option value="<?= $category->name ?>">
            <?= "$category->parentCategory->name ~ $category->name" ?>
          </option>
        <?php else: ?>
          <option><?= $category->name ?></option>
        <?php endif ?>
      <?php endforeach ?>
    </select>
    <select name="group">
      <option value="">Selecciona un grupo</option>
      <?php foreach ($groups as $group): ?>
        <option><?= $group->name ?></option>
      <?php endforeach ?>
    </select>
    <select name="dependencies[]" multiple>
      <option selected value="">Selecciona las dependencias</option>
      <?php foreach ($plugins as $dependency): ?>
        <option value="<?= $dependency->id ?>">
          <?= "{$dependency->modder->name}: $dependency->name" ?>
        </option>
      <?php endforeach ?>
    </select>
    <select name="containedPlugins[]" multiple>
      <option value="" selected>Selecciona los plugins contenidos</option>
      <?php foreach ($plugins as $contained): ?>
        <option value="<?= $contained->id ?>">
          <?= "{$contained->modder->name}: $contained->name" ?>
        </option>
      <?php endforeach ?>
    </select>
    <button type="submit">Registrar</button>
  </form>
</section>

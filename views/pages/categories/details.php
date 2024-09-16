<?php

use SC4S\Models\Category;

/** @var Category $category */

?>

<h1><?= $category->name ?></h1>
<?php if ($category->hasSubcategories()): ?>
  <section>
    <h2>Subcategorías</h2>
    <ul>
      <?php foreach ($category->subcategories as $subCategory): ?>
        <li>
          <?= $subCategory->name ?>
          <a href="./categorias/<?= $subCategory->name ?>/editar">Editar</a>
        </li>
      <?php endforeach ?>
    </ul>
  </section>
<?php endif ?>

<?php if ($category->hasPlugins()): ?>
  <section>
    <h2>Plugins</h2>
    <ul>
      <?php foreach ($category->plugins as $plugin): ?>
        <li>
          <a
            href="<?= $plugin->downloadPageLink ?>"
            target="_blank">
            <?= $plugin->name ?>
          </a>
          <?php if ($plugin->hasDependencies()): ?>
            <ul>
              <li>Dependencias</li>
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
<?php endif ?>

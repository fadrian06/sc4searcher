<?php

use SC4S\Models\Category;

/** @var Category[] $categories */

?>

<section>
  <h1>Categorías</h1>
  <ul>
    <?php foreach ($categories as $category): ?>
      <?php if (!$category->isSubcategory()): ?>
        <li>
          <?php if ($category->hasSubcategories()): ?>
            <?= $category->name ?>
          <?php else: ?>
            <a href="./categorias/<?= $category->name ?>"><?= $category->name ?></a>
          <?php endif ?>
          <a href="./categorias/<?= $category->name ?>/editar">Editar</a>
          <?php if (!$category->hasSubcategories()): ?>
            <a href="./categorias/<?= $category->name ?>/eliminar">Eliminar</a>
          <?php endif ?>
          <?php if ($category->hasSubcategories()): ?>
            <ul>
              <?php foreach ($category->subcategories as $subcategory): ?>
                <li>
                  <a href="./categorias/<?= $subcategory->name ?>">
                    <?= $subcategory->name ?>
                  </a>
                  <a href="./categorias/<?= $subcategory->name ?>/editar">
                    Editar
                  </a>
                  <?php if (!$subcategory->hasSubcategories()): ?>
                    <a href="./categorias/<?= $subcategory->name ?>/eliminar">
                      Eliminar
                    </a>
                  <?php endif ?>
                </li>
              <?php endforeach ?>
            </ul>
          <?php endif ?>
        </li>
      <?php endif ?>
    <?php endforeach ?>
  </ul>
</section>

<section>
  <h2>Añadir categoría</h2>
  <form method="post">
    <input name="name" placeholder="Nombre" />
    <select name="parentCategory">
      <option value="">Selecciona una categoría contenedora</option>
      <?php foreach ($categories as $category): ?>
        <?php if ($category->isSubcategory()): ?>
          <option value="<?= $category->name ?>"><?= "$category->parentCategory->name ~ $category->name" ?></option>
        <?php else: ?>
          <option><?= $category->name ?></option>
        <?php endif ?>
      <?php endforeach ?>
    </select>
    <button type="submit">Añadir</button>
  </form>
</section>

<?php

use SC4S\Models\Category;

/** @var Category[] $categories */

/** @return object{name: string} */
function getTranslation(Category $category): object
{
  $filePath = ROOT . "/translations/categories/$category->name.json";

  if (file_exists($filePath)) {
    $fileContents = file_get_contents($filePath);
    $translations = json_decode($fileContents);

    if (property_exists($translations, $_SESSION['configuration']['language']->value)) {
      return $translations->{$_SESSION['configuration']['language']->value};
    }
  }

  return $category;
}

?>

<section>
  <h1>Categorías</h1>
  <ul>
    <?php foreach ($categories as $category): ?>
      <?php if (!$category->isSubcategory()): ?>
        <li>
          <?php if ($category->hasSubcategories()): ?>
            <?= getTranslation($category)->name ?>
          <?php else: ?>
            <a href="./categorias/<?= $category->name ?>">
              <?= getTranslation($category)->name ?>
            </a>
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

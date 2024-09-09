<section>
  <h1>Categorías</h1>
  <ul>
    <?php foreach (
      $categories ?? [] as [
        'name' => $category,
        'subCategories' => $subCategories,
        'parentCategory' => $parentCategory,
        'canBeDeleted' => $canBeDeleted
      ]
    ): ?>
      <?php if (!$parentCategory): ?>
        <li>
          <?php if ($subCategories): ?>
            <?= $category ?>
          <?php else: ?>
            <a href="./categorias/<?= $category ?>"><?= $category ?></a>
          <?php endif ?>
          <a href="./categorias/<?= $category ?>/editar">Editar</a>
          <?php if ($canBeDeleted): ?>
            <a href="./categorias/<?= $category ?>/eliminar">Eliminar</a>
          <?php endif ?>
          <?php if ($subCategories): ?>
            <ul>
              <?php foreach (
                $subCategories as [
                  'name' => $category,
                  'canBeDeleted' => $canBeDeleted
                ]
              ): ?>
                <li>
                  <a href="./categorias/<?= $category ?>"><?= $category ?></a>
                  <a href="./categorias/<?= $category ?>/editar">Editar</a>
                  <?php if ($canBeDeleted): ?>
                    <a href="./categorias/<?= $category ?>/eliminar">Eliminar</a>
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
      <?php foreach (
        $categories as [
          'name' => $category,
          'parentCategory' => $parentCategory
        ]
      ): ?>
        <?php if ($parentCategory): ?>
          <option value="<?= $category ?>"><?= "$parentCategory ~ $category" ?></option>
        <?php else: ?>
          <option><?= $category ?></option>
        <?php endif ?>
      <?php endforeach ?>
    </select>
    <button type="submit">Añadir</button>
  </form>
</section>

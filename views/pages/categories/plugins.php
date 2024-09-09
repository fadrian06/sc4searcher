<h1><?= $category['name'] ?></h1>
<?php if ($category['subCategories']): ?>
  <section>
    <h2>Subcategorías</h2>
    <ul>
      <?php foreach ($category['subCategories'] as ['name' => $subCategory]): ?>
        <li>
          <?= $subCategory ?>
          <a href="./categorias/<?= $subCategory ?>/editar">Editar</a>
        </li>
      <?php endforeach ?>
    </ul>
  </section>
<?php endif ?>

<?php if ($category['plugins']): ?>
  <section>
    <h2>Plugins</h2>
    <ul>
      <?php foreach (
        $category['plugins'] as [
          'name' => $plugin,
          'link' => $href,
          'dependencies' => $dependencies
        ]
      ): ?>
        <li>
          <a
            href="<?= $href ?>"
            target="_blank"
            title="Ver en Simtropolis">
            <?= $plugin ?>
          </a>
          <?php if ($dependencies): ?>
            <ul>
              <li>Dependencies</li>
              <?php foreach ($dependencies as ['name' => $plugin, 'link' => $href]): ?>
                <li>
                  <a
                    href="<?= $href ?>"
                    target="_blank"
                    title="Ver en Simtropolis">
                    <?= $plugin ?>
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

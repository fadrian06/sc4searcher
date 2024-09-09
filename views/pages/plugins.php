<section>
  <h1>Plugins</h1>
  <ul>
    <?php foreach (
      $plugins ?? [] as [
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
      <?php foreach ($modders as ['name' => $modder]): ?>
        <option><?= $modder ?></option>
      <?php endforeach ?>
    </select>
    <select name="category" required>
      <option value="">Selecciona una categoría</option>
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
    <select name="group">
      <option value="">Selecciona un grupo</option>
      <?php foreach ($groups as ['name' => $group]): ?>
        <option><?= $group ?></option>
      <?php endforeach ?>
    </select>
    <select name="dependencies[]" multiple>
      <option selected value="">Selecciona las dependencias</option>
      <?php foreach ($plugins as ['id' => $id, 'name' => $dependency, 'modder' => $modder]): ?>
        <option value="<?= $id ?>"><?= "{$modder['name']}: $dependency" ?></option>
      <?php endforeach ?>
    </select>
    <button type="submit">Registrar</button>
  </form>
</section>

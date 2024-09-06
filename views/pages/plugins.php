<section>
  <h1>Plugins</h1>
  <ul>
    <?php foreach ($plugins ?? [] as ['name' => $plugin, 'link' => $href]): ?>
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
</section>

<section>
  <h2>Registrar plugin</h2>
  <form method="post">
    <input name="name" placeholder="Nombre" required />
    <input
      type="url"
      name="link"
      placeholder="URL del perfil de Simtropolis"
      pattern="https:\/\/community\.simtropolis\.com\/profile\[/\w\/]+" />
    <select name="modder" required>
      <option value="">Selecciona un modder</option>
      <?php foreach ($modders as ['name' => $modder]): ?>
        <option><?= $modder ?></option>
      <?php endforeach ?>
    </select>
    <select name="modder" required>
      <option value="">Selecciona una categoría</option>
      <?php foreach ($categories as ['name' => $category]): ?>
        <option><?= $category ?></option>
      <?php endforeach ?>
    </select>
    <select name="group">
      <option value="">Selecciona un grupo</option>
      <?php foreach ($groups as ['name' => $group]): ?>
        <option><?= $group ?></option>
      <?php endforeach ?>
    </select>
    <button>Registrar</button>
  </form>
</section>

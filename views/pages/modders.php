<section>
  <h1>Modders</h1>
  <ul>
    <?php foreach ($modders ?? [] as ['name' => $modder, 'link' => $href]): ?>
      <li>
        <a
          href="<?= $href ?>?do=content&type=downloads_file&change_section=1"
          target="_blank"
          title="Ver perfil de <?= $modder ?> en Simtropolis">
          <?= $modder ?>
        </a>
        <a href="./modders/<?= $modder ?>/eliminar" role="button">Eliminar</a>
      </li>
    <?php endforeach ?>
  </ul>
</section>

<section>
  <h2>Registrar modder</h2>
  <form method="post">
    <input name="name" placeholder="Nombre" required />
    <input
      type="url"
      name="link"
      placeholder="URL del perfil de Simtropolis"
      pattern="https://community\.simtropolis\.com/profile/[\w\-\/]+" />
    <button type="submit">Registrar</button>
  </form>
</section>

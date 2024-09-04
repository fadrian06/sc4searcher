<section>
  <h1>Modders</h1>
  <ul>
    <?php foreach ($modders ?? [] as ['name' => $modder, 'link' => $href]): ?>
      <li>
        <a
          href="<?= $href ?>"
          target="_blank"
          title="Ver perfil de <?= $modder ?> en Simtropolis">
          <?= $modder ?>
        </a>
      </li>
    <?php endforeach ?>
  </ul>
</section>

<section>
  <h2>Registrar modder</h2>
  <form method="post">
    <input
      type="url"
      name="link"
      placeholder="URL del perfil de Simtropolis"
      pattern="https:\/\/community\.simtropolis\.com\/profile\[/\w\/]+" />
    <button>Registrar</button>
  </form>
</section>

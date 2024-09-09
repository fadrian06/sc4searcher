<section>
  <h1>Grupos</h1>
  <ul>
    <?php foreach ($groups ?? [] as ['name' => $group]): ?>
      <li><?= $group ?></li>
    <?php endforeach ?>
  </ul>
</section>

<section>
  <h2>Registrar grupo</h2>
  <form method="post">
    <input name="name" placeholder="Nombre" required />
    <button type="submit">Registrar</button>
  </form>
</section>

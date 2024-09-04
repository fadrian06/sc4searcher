<section>
  <h1>Categorías</h1>
  <ul>
    <?php foreach ($categories ?? [] as ['name' => $category]): ?>
      <li><?= $category ?></li>
    <?php endforeach ?>
  </ul>
</section>

<section>
  <h2>Añadir categoría</h2>
  <form method="post">
    <input name="name" placeholder="Nombre" />
    <button>Añadir</button>
  </form>
</section>

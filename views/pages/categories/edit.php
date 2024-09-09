<h1>Editar categoría</h1>
<form method="post">
  <input
    name="name"
    placeholder="Nuevo nombre"
    required
    value="<?= $category['name'] ?>" />
  <select name="parentCategory">
    <option value="">Selecciona una categoría contenedora</option>
    <?php foreach ($categories as ['name' => $parentCategory]): ?>
      <option <?= $parentCategory === $category['parentCategory'] ? 'selected' : '' ?>>
        <?= $parentCategory ?>
      </option>
    <?php endforeach ?>
  </select>
  <button type="submit">Actualizar</button>
</form>

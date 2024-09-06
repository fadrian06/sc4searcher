<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width" />
  <title><?= $title ?> - SC4Searcher</title>
  <base href="<?= str_replace('index.php', '', $_SERVER['SCRIPT_NAME']) ?>" />
  <link rel="icon" href="./assets/images/5943701118498485671.png" />
</head>

<body>
  <menu>
    <a href="./">Inicio</a>
    <a href="./categorias">Categorías</a>
    <a href="./modders">Modders</a>
    <a href="./grupos">Grupos</a>
    <a href="./plugins">Plugins</a>
    <?php if (isset($_SESSION['user'])): ?>
      <a href="./salir">Cerrar sesión</a>
    <?php else: ?>
      <a href="./ingresar">Ingresar</a>
      <a href="./registrarse">Registrarse</a>
    <?php endif ?>
  </menu>
  <?= $page ?>
</body>

</html>

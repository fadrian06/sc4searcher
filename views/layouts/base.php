<!DOCTYPE html>
<html data-theme="dark">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width" />
  <title><?= $title ?> - SC4Searcher</title>
  <base href="<?= str_replace('index.php', '', $_SERVER['SCRIPT_NAME']) ?>" />
  <link rel="icon" href="./assets/images/5943701118498485671.png" />
  <link
    rel="stylesheet"
    href="./vendor/picocss/pico/css/pico.classless.lime.min.css" />
</head>

<body>
  <header>
    <nav>
      <li>
        <ul>
          <h1>
            <img src="./assets/images/5943701118498485671.png" width="64" />
            <a href="./">SC4Searcher</a>
          </h1>
        </ul>
      </li>
      <menu>
        <a href="./categorias">Categorías</a>
        <a href="./modders">Modders</a>
        <a href="./grupos">Grupos</a>
        <a href="./plugins">Plugins</a>
        <?php if (isset($_SESSION['user'])): ?>
          <a role="button" href="./salir">Cerrar sesión</a>
        <?php else: ?>
          <a role="button" href="./ingresar">Ingresar</a>
          <a role="button" href="./registrarse">Registrarse</a>
        <?php endif ?>
      </menu>
    </nav>
  </header>
  <main><?= $page ?></main>
  <footer>
    <h3>Comunidades</h3>
    <ul>
      <li>
        <a href="https://community.simtropolis.com" target="_blank">Simtropolis</a>
      </li>
      <li>
        <a href="https://sc4evermore.com" target="_blank">Sc4Evermore</a>
      </li>
      <li>
        <a href="http://hide-inoki.com" target="_blank">Hide-Inoki</a>
      </li>
    </ul>
    <h4>
      Síguenos en
      <a href="https://chat.whatsapp.com/Jc7PCiVQEV8LhVfbSb3Rdx" target="_blank"><img src="./assets/images/whatsapp.ico" width="32" /></a>
      o
      <a href="https://t.me/sc4fandomteam"><img src="./assets/images/telegram.png" width="32" /></a>
    </h4>
  </footer>
  <?php if (isset($_GET['error'])): ?>
    <script>alert(`<?= urldecode($_GET['error']) ?>`)</script>
  <?php endif ?>
</body>

</html>

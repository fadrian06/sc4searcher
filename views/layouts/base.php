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
    <div role="group">
      <a href="https://community.simtropolis.com" target="_blank">
        <img src="./assets/images/simtropolis.png" />
      </a>
      <a href="https://sc4evermore.com" target="_blank">
        <img src="./assets/images/sc4evermore.png" />
      </a>
      <a href="http://hide-inoki.com" target="_blank">
        <img src="./assets/images/hide-inoki.png" />
      </a>
    </div>
    <div role="group">
      <a href="https://toutsimcities.com/" target="_blank">
        <img src="./assets/images/toutsimcities.png" />
      </a>
      <a href="https://cafe.naver.com/simcitysquare/?viewType=pc" target="_blank">
        <img src="./assets/images/simcitysquare.png" />
      </a>
    </div>
    <h4>
      Síguenos en
      <div role="group">
        <a href="https://chat.whatsapp.com/Jc7PCiVQEV8LhVfbSb3Rdx" target="_blank">
          <img src="./assets/images/whatsapp.ico" width="32" />
          <img src="./assets/images/5945953798780466410.jpg" />
        </a>
        <a href="https://t.me/sc4fandomteam">
          <img src="./assets/images/telegram.png" width="32" />
          <img src="./assets/images/5946212695114102063.jpg" />
        </a>
      </div>
    </h4>
  </footer>
  <?php if (isset($_GET['error'])): ?>
    <script>
      alert(`<?= urldecode($_GET['error']) ?>`)
    </script>
  <?php endif ?>
</body>

</html>

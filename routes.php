<?php

declare(strict_types=1);

use flight\net\Router;

require_once 'utils.php';

Flight::route('/', function (): void {
  Flight::render('pages/home', [], 'page');
  Flight::render('layouts/base', ['title' => 'Inicio']);
});

Flight::group('/ingresar', function (Router $router): void {
  $router->get('/', function (): void {
    Flight::render('pages/login', [], 'page');
    Flight::render('layouts/base', ['title' => 'Iniciar sesión']);
  });

  $router->post('/', function (): void {
    $credentials = Flight::request()->data;

    var_dump($credentials);
  });
});

Flight::group('/registrarse', function (Router $router): void {
  $router->get('/', function (): void {
    Flight::render('pages/register', [], 'page');
    Flight::render('layouts/base', ['title' => 'Registrarse']);
  });

  $router->post('/', function (): void {
    $credentials = Flight::request()->data;

    $stmt = Flight::get('db')->prepare(<<<sql
      INSERT INTO users
      VALUES (:username, :password)
    sql);

    $stmt->bindValue(':username', $credentials->username);

    $stmt->bindValue(
      ':password',
      password_hash($credentials->password, PASSWORD_DEFAULT)
    );

    $stmt->execute();
    Flight::redirect('/ingresar');
  });
});

Flight::group('/categorias', function (Router $router): void {
  $router->get('/', function (): void {
    Flight::render('pages/categories', ['categories' => getCategories()], 'page');
    Flight::render('layouts/base', ['title' => 'Categorías']);
  });

  $router->post('/', function (): void {
    $category = Flight::request()->data;

    $stmt = Flight::get('db')->prepare(<<<sql
      INSERT INTO categories (name)
      VALUES (:name)
    sql);

    $stmt->bindValue(':name', mb_convert_case($category->name, MB_CASE_TITLE));
    $stmt->execute();

    Flight::redirect('/categorias');
  });
});

Flight::group('/plugins', function (Router $router): void {
  $router->get('/', function (): void {
    Flight::render(
      'pages/plugins',
      [
        'plugins' => getPlugins(),
        'modders' => getModders(),
        'categories' => getCategories(),
        'grupos' => getGroups()
      ],
      'page'
    );
    Flight::render('layouts/base', ['title' => 'Plugins']);
  });

  $router->post('/', function (): void {});
});

Flight::group('/modders', function (Router $router): void {
  $router->get('/', function (): void {
    Flight::render('pages/modders', ['modders' => getModders()], 'page');
    Flight::render('layouts/base', ['title' => 'Modders']);
  });

  $router->post('/', function (): void {
    $modder = Flight::request()->data;

    if (str_ends_with($modder->link, '/')) {
      $modder->link = substr($modder->link, 0, -1);
    }

    [, $modderName] = explode('-', $modder->link);

    $stmt = Flight::get('db')->prepare(<<<sql
      INSERT INTO modders (name, link)
      VALUES (:name, :link)
    sql);

    $stmt->bindValue(':name', $modderName);
    $stmt->bindValue(':link', $modder->link);
    $stmt->execute();

    Flight::redirect('/modders');
  });
});

Flight::group('/grupos', function (Router $router): void {
  $router->get('/', function (): void {
    Flight::render('pages/groups', ['groups' => getGroups()], 'page');
    Flight::render('layouts/base', ['title' => 'Grupos']);
  });

  $router->post('/', function (): void {
    $group = Flight::request()->data;

    $stmt = Flight::get('db')->prepare(<<<sql
      INSERT INTO groups
      VALUES (:name)
    sql);

    $stmt->bindValue(':name', $group->name);
    $stmt->execute();

    Flight::redirect('/grupos');
  });
});

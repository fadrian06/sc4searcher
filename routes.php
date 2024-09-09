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
    Flight::render(
      'pages/categories/list',
      ['categories' => getCategories()],
      'page'
    );
    Flight::render('layouts/base', ['title' => 'Categorías']);
  });

  $router->post('/', function (): void {
    $category = Flight::request()->data;

    $stmt = Flight::get('db')->prepare(<<<sql
      INSERT INTO categories (name, parent_category)
      VALUES (:name, :parentCategory)
    sql);

    $stmt->bindValue(':name', mb_convert_case($category->name, MB_CASE_TITLE));
    $stmt->bindValue(':parentCategory', $category->parentCategory ?: null);
    $stmt->execute();

    Flight::redirect('/categorias');
  });

  $router->group('/@category', function (Router $router): void {
    $router->get('/', function (string $category): void {
      echo "Plugins de la categoría $category";
    });

    $router->map('/eliminar', function (string $category): void {
      $stmt = Flight::get('db')->prepare('DELETE FROM categories WHERE name = :name');
      $stmt->bindValue(':name', $category);
      $stmt->execute();
    });

    $router->group('/editar', function (Router $router): void {
      $router->get('/', function (string $categoryName): void {
        Flight::render(
          'pages/categories/edit',
          [
            'category' => getCategoryByName($categoryName),
            'categories' => array_filter(
              getCategories(),
              fn(array $category): bool => $category['name'] !== $categoryName
            )
          ],
          'page'
        );

        Flight::render('layouts/base', ['title' => 'Editar categoría']);
      });

      $router->post('/', function (string $oldName): void {
        $updatedCategory = Flight::request()->data;

        $stmt = Flight::get('db')->prepare(<<<sql
          UPDATE categories SET name = :newName, parent_category = :newParentCategory
          WHERE name = :oldName
        sql);

        $stmt->bindValue(':newName', $updatedCategory->name);
        $stmt->bindValue(':newParentCategory', $updatedCategory->parentCategory ?: null);
        $stmt->bindValue(':oldName', $oldName);
        $stmt->execute();

        Flight::redirect('/categorias');
      });
    });
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
        'groups' => getGroups()
      ],
      'page'
    );

    Flight::render('layouts/base', ['title' => 'Plugins']);
  });

  $router->post('/', function (): void {
    $plugin = Flight::request()->data;
    $pluginNameRaw = explode('-', substr($plugin->link, 0, -1));
    array_shift($pluginNameRaw);
    $plugin->name = ucwords(implode(' ', $pluginNameRaw));

    $stmt = Flight::get('db')->prepare(<<<sql
      INSERT INTO plugins (
        name, link, version, submitted, updated,
        description, installation, modder, category, group_name
      ) VALUES (
        :name, :link, :version, :submitted, :updated, :description,
        :installation, :modder, :category, :group
      )
    sql);

    $stmt->bindValue(':name', $plugin->name);
    $stmt->bindValue(':link', $plugin->link);
    $stmt->bindValue(':version', $plugin->version);
    $stmt->bindValue(':submitted', $plugin->submitted);
    $stmt->bindValue(':updated', $plugin->updated);
    $stmt->bindValue(':description', $plugin->description ?: null);
    $stmt->bindValue(':installation', $plugin->installation);
    $stmt->bindValue(':modder', $plugin->modder);
    $stmt->bindValue(':category', $plugin->category);
    $stmt->bindValue(':group', $plugin->group ?: null);
    $result = @$stmt->execute();

    if (!$result) {
      Flight::redirect('/plugins?error=' . urlencode("Plugin $plugin->name ya existe ~ " . Flight::get('db')->lastErrorMsg()));

      return;
    }

    $plugin->id = Flight::get('db')->lastInsertRowID();

    if (array_filter($plugin->dependencies)) {
      $values = implode(', ', array_map(
        fn(int $dependencyId): string => "($plugin->id, $dependencyId)",
        $plugin->dependencies
      ));

      $sql = <<<sql
        INSERT INTO dependencies
        VALUES $values
      sql;

      Flight::get('db')->query($sql);
      Flight::redirect('/plugins');
    }
  });
});

Flight::group('/modders', function (Router $router): void {
  $router->get('/', function (): void {
    Flight::render('pages/modders', ['modders' => getModders()], 'page');
    Flight::render('layouts/base', ['title' => 'Modders']);
  });

  $router->group('/@modder', function (Router $router): void {
    $router->map('/eliminar', function (string $modder): void {
      $stmt = Flight::get('db')->prepare('DELETE FROM modders WHERE name = :name');
      $stmt->bindValue(':name', $modder);
      $stmt->execute();
      Flight::redirect('/modders');
    });
  });

  $router->post('/', function (): void {
    $modder = Flight::request()->data;

    $stmt = Flight::get('db')->prepare(<<<sql
      INSERT INTO modders (name, link)
      VALUES (:name, :link)
    sql);

    $stmt->bindValue(':name', $modder->name);
    $stmt->bindValue(':link', $modder->link);
    $result = @$stmt->execute();

    if (!$result) {
      Flight::redirect('/modders?error=' . urlencode("Modder $modder->name ya existe"));

      return;
    }

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

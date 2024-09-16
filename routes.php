<?php

declare(strict_types=1);

use flight\net\Router;
use SC4S\Controllers\CategoryController;
use SC4S\Controllers\GroupController;
use SC4S\Controllers\ModderController;
use SC4S\Controllers\PluginController;

Flight::route('/salir', function (): void {
  unset($_SESSION['user']);
  Flight::redirect(Flight::request()->referrer);
});

Flight::route('/', function (): void {
  Flight::render('pages/home', [], 'page');
  Flight::render('layouts/base', ['title' => 'Inicio']);
});

Flight::group('/ingresar', function (Router $router): void {
  $router->get('/', function (): void {
    Flight::render('pages/login', [], 'page');
    Flight::render('layouts/base', ['title' => 'Iniciar sesión']);
  });

  $router->post('/', function (): void {});
});

Flight::group('/registrarse', function (Router $router): void {
  $router->get('/', function (): void {
    Flight::render('pages/register', [], 'page');
    Flight::render('layouts/base', ['title' => 'Registrarse']);
  });

  $router->post('/', function (): void {});
});

Flight::group('/categorias', function (Router $router): void {
  $router->get('/', [CategoryController::class, 'showCategories']);
  $router->post('/', [CategoryController::class, 'addCategory']);

  $router->group('/@category', function (Router $router): void {
    $router->get('/', [CategoryController::class, 'showCategory']);
    $router->map('/eliminar', [CategoryController::class, 'deleteCategory']);

    $router->group('/editar', function (Router $router): void {
      $router->get('/', function (string $categoryName): void {});
      $router->post('/', function (string $oldName): void {});
    });
  });
});

Flight::group('/plugins', function (Router $router): void {
  $router->get('/', [PluginController::class, 'showPlugins']);

  $router->group('/@pluginId', function (Router $router): void {
    $router->get('/', [PluginController::class, 'showPlugin']);
  });

  $router->post('/', [PluginController::class, 'addPlugin']);
});

Flight::group('/modders', function (Router $router): void {
  $router->get('/', [ModderController::class, 'showModders']);
  $router->post('/', [ModderController::class, 'addModder']);

  $router->group('/@modder', function (Router $router): void {
    $router->map('/eliminar', [ModderController::class, 'deleteModder']);
    $router->get('/', [ModderController::class, 'showModder']);
  });
});

Flight::group('/grupos', function (Router $router): void {
  $router->get('/', [GroupController::class, 'showGroups']);
  $router->post('/', [GroupController::class, 'addGroup']);
});

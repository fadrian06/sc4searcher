<?php

declare(strict_types=1);

use Illuminate\Container\Container;
use SC4S\Exceptions\ResourceNotFound;
use SC4S\Repositories\Implementations\PDO\PDOCategoryRepository;
use SC4S\Repositories\Implementations\PDO\PDOModderRepository;
use SC4S\Repositories\Interfaces\CategoryRepository;
use SC4S\Repositories\Interfaces\ModderRepository;

require_once 'vendor/autoload.php';
require_once 'routes.php';

$container = new Container;

$container->bind(PDO::class, fn(): PDO => new PDO(
  'sqlite:sc4searcher.db',
  options: [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
), true);

$container->bind(ModderRepository::class, PDOModderRepository::class, true);
$container->bind(CategoryRepository::class, PDOCategoryRepository::class, true);

Flight::registerContainerHandler([$container, 'get']);
session_start();

try {
  Flight::start();
} catch (ResourceNotFound $exception) {
  http_response_code(404);
  Flight::render('pages/errors/404', ['message' => $exception->getMessage()], 'page');
  Flight::render('layouts/base', ['title' => '404 | Recurso no encontrado']);
}

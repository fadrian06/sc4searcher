<?php

declare(strict_types=1);

use Illuminate\Container\Container;
use SC4S\Exceptions\ResourceNotFound;
use SC4S\Repositories\Implementations\PDO\PDOModderRepository;
use SC4S\Repositories\Interfaces\ModderRepository;

require_once 'vendor/autoload.php';
require_once 'routes.php';

$container = new Container;
$container->bind(PDO::class, fn(): PDO => db(), true);
$container->bind(ModderRepository::class, PDOModderRepository::class, true);
Flight::registerContainerHandler(fn(string $fqcn): object => $container->get($fqcn));

session_start();

try {
  Flight::start();
} catch (ResourceNotFound $exception) {
  http_response_code(404);
  Flight::render('pages/errors/404', ['message' => $exception->getMessage()], 'page');
  Flight::render('layouts/base', ['title' => '404 | Recurso no encontrado']);
}

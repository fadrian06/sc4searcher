<?php

declare(strict_types=1);

use SC4S\Enums\Translation;
use SC4S\Exceptions\ResourceNotFound;

const ROOT = __DIR__;

require_once 'vendor/autoload.php';
require_once 'container.php';
require_once 'routes.php';

session_start();
$_SESSION['configuration']['language'] ??= Translation::ENGLISH;

try {
  Flight::start();
} catch (ResourceNotFound $exception) {
  http_response_code(404);
  Flight::render('pages/errors/404', ['message' => $exception->getMessage()], 'page');
  Flight::render('layouts/base', ['title' => '404 | Recurso no encontrado']);
}

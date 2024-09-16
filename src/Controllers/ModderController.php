<?php

namespace SC4S\Controllers;

use Flight;
use SC4S\Exceptions\ResourceNotFound;
use SC4S\Repositories\Interfaces\ModderRepository;

final readonly class ModderController
{
  function __construct(private ModderRepository $repository) {}

  function showModders(): void
  {
    Flight::render('pages/modders/list', ['modders' => $this->repository->getAll()], 'page');
    Flight::render('layouts/base', ['title' => 'Modders']);
  }

  function showModder(string $modderName): void
  {
    $modder = $this->repository->getByName($modderName) ?? throw new ResourceNotFound("El modder $modderName no ha sido registrado");

    Flight::render('pages/modders/profile', compact('modder'), 'page');
    Flight::render('layouts/base', ['title' => $modderName]);
  }
}

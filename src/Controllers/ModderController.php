<?php

namespace SC4S\Controllers;

use Flight;
use SC4S\Exceptions\ResourceNotFound;
use SC4S\Models\Modder;
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

  function deleteModder(string $modderName): void
  {
    $this->repository->deleteByName($modderName);
    $this->showModders();
  }

  function addModder(): void
  {
    $modderCollection = Flight::request()->data;
    $modder = new Modder($modderCollection->name, $modderCollection->link);
    $result = $this->repository->save($modder);

    if (!$result->wasSuccessfully()) {
      Flight::redirect("/modders?error=$result->error");
    } else {
      Flight::redirect(Flight::request()->referrer);
    }
  }
}

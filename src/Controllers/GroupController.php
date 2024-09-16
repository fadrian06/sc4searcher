<?php

namespace SC4S\Controllers;

use Flight;
use SC4S\Exceptions\ResourceNotFound;
use SC4S\Models\Group;
use SC4S\Repositories\Interfaces\GroupRepository;

final readonly class GroupController
{
  function __construct(private GroupRepository $repository) {}

  function showGroups(): void
  {
    Flight::render('pages/groups/list', ['groups' => $this->repository->getAll()], 'page');
    Flight::render('layouts/base', ['title' => 'Grupos']);
  }

  function addGroup(): void
  {
    $groupCollection = Flight::request()->data;
    $group = new Group($groupCollection->name);
    $result = $this->repository->save($group);

    if (!$result->wasSuccessfully()) {
      Flight::redirect("/grupos?error=$result->error");
    } else {
      Flight::redirect(Flight::request()->referrer);
    }
  }

  function showGroup(string $groupName): void
  {
    $group = $this->repository->getByName($groupName) ?? throw new ResourceNotFound("El grupo $groupName no ha sido registrado");

    Flight::render('pages/categories/details', compact('group'), 'page');
    Flight::render('layouts/base', ['title' => $groupName]);
  }

  function deleteGroup(string $groupName): void
  {
    $this->repository->deleteByName($groupName);
    Flight::redirect('/grupos');
  }
}

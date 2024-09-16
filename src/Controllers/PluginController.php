<?php

namespace SC4S\Controllers;

use Flight;
use SC4S\Exceptions\ResourceNotFound;
use SC4S\Repositories\Interfaces\CategoryRepository;
use SC4S\Repositories\Interfaces\GroupRepository;
use SC4S\Repositories\Interfaces\ModderRepository;
use SC4S\Repositories\Interfaces\PluginRepository;

final readonly class PluginController
{
  function __construct(
    private PluginRepository $pluginRepository,
    private ModderRepository $modderRepository,
    private CategoryRepository $categoryRepository,
    private GroupRepository $groupRepository
  ) {}

  function showPlugins(): void
  {
    Flight::render('pages/plugins/list', [
      'plugins' => $this->pluginRepository->getAll(),
      'modders' => $this->modderRepository->getAll(),
      'categories' => $this->categoryRepository->getAll(),
      'groups' => $this->groupRepository->getAll()
    ], 'page');
    Flight::render('layouts/base', ['title' => 'Plugins']);
  }

  function showPlugin(int $pluginId): void
  {
    $plugin = $this->pluginRepository->getById($pluginId) ?? throw new ResourceNotFound("El plugin #$pluginId no ha sido registrado");

    Flight::render('pages/plugins/details', compact('plugin'), 'page');
    Flight::render('layouts/base', ['title' => $plugin->name]);
  }
}

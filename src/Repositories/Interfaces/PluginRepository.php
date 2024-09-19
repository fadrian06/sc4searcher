<?php

namespace SC4S\Repositories\Interfaces;

use SC4S\Models\Modder;
use SC4S\Models\Plugin;
use SC4S\Result\EmptyResult;

interface PluginRepository
{
  /** @return Plugin[] */
  function getAll(): array;

  function getById(int $pluginId): ?Plugin;

  /** @return PLugin[] */
  function getByModder(Modder $modder): array;

  function save(Plugin $plugin): EmptyResult;
  function deleteById(int $pluginId): EmptyResult;
}

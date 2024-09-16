<?php

namespace SC4S\Repositories\Interfaces;

use SC4S\Models\Modder;

interface ModderRepository
{
  /** @return Modder[] */
  function getAll(): array;
  function getByName(string $modderName): ?Modder;
}

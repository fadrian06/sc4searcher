<?php

namespace SC4S\Repositories\Interfaces;

use SC4S\Models\Modder;
use SC4S\Result\EmptyResult;

interface ModderRepository
{
  /** @return Modder[] */
  function getAll(): array;
  function getByName(string $modderName): ?Modder;
  function deleteByName(string $modderName): EmptyResult;
  function save(Modder $modder): EmptyResult;
}

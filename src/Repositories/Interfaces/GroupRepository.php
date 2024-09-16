<?php

namespace SC4S\Repositories\Interfaces;

use SC4S\Models\Group;
use SC4S\Result\EmptyResult;

interface GroupRepository
{
  /** @return Group[] */
  function getAll(): array;
  function getByName(string $groupName): ?Group;
  function save(Group $group): EmptyResult;
  function deleteByName(string $groupName): EmptyResult;
}

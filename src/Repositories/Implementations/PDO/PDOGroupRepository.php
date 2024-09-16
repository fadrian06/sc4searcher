<?php

namespace SC4S\Repositories\Implementations\PDO;

use PDO;
use SC4S\Models\Group;
use SC4S\Repositories\Interfaces\GroupRepository;
use SC4S\Result\EmptyResult;

final readonly class PDOGroupRepository implements GroupRepository
{
  function __construct(private PDO $pdo) {}

  function getAll(): array
  {
    $stmt = $this->pdo->query('SELECT * FROM groups');
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_FUNC, [self::class, 'mapper']);
  }

  function getByName(string $groupName): ?Group
  {
    return null;
  }

  function save(Group $group): EmptyResult
  {
    return EmptyResult::success();
  }

  function deleteByName(string $groupName): EmptyResult
  {
    return EmptyResult::success();
  }

  private static function mapper(string $name): Group
  {
    return new Group($name);
  }
}

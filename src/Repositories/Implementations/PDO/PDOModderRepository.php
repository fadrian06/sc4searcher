<?php

namespace SC4S\Repositories\Implementations\PDO;

use PDO;
use SC4S\Models\Modder;
use SC4S\Repositories\Interfaces\ModderRepository;

final readonly class PDOModderRepository implements ModderRepository
{
  function __construct(private PDO $pdo) {}

  function getAll(): array
  {
    $stmt = $this->pdo->query('SELECT * FROM modders');
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_FUNC, [self::class, 'mapper']);
  }

  function getByName(string $modderName): ?Modder
  {
    $stmt = $this->pdo->prepare('SELECT * FROM modders WHERE name = ?');
    $stmt->execute([$modderName]);
    $modderArray = $stmt->fetch();

    if (!$modderArray) {
      return null;
    }

    return self::mapper($modderArray['name'], $modderArray['link']);
  }

  private static function mapper(string $modderName, string $modderLink): Modder
  {
    return new Modder($modderName, $modderLink, []);
  }
}

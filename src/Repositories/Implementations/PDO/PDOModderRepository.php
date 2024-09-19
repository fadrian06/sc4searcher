<?php

namespace SC4S\Repositories\Implementations\PDO;

use PDO;
use PDOException;
use SC4S\Models\Modder;
use SC4S\Repositories\Interfaces\ModderRepository;
use SC4S\Result\EmptyResult;

final class PDOModderRepository implements ModderRepository
{
  function __construct(private readonly PDO $pdo) {}

  function getAll(): array
  {
    $stmt = $this->pdo->query('SELECT * FROM modders');
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_FUNC, [$this, 'mapper']);
  }

  function getByName(string $modderName): ?Modder
  {
    $stmt = $this->pdo->prepare('SELECT * FROM modders WHERE name = ?');
    $stmt->execute([$modderName]);
    $modderArray = $stmt->fetch();

    if (!$modderArray) {
      return null;
    }

    return $this->mapper(
      $modderArray['name'],
      $modderArray['profile_link'],
      $modderArray['profile_image_link']
    );
  }

  function deleteByName(string $modderName): EmptyResult
  {
    $stmt = $this->pdo->prepare('DELETE FROM modders WHERE name = ?');
    $stmt->execute([$modderName]);

    return EmptyResult::success();
  }

  function save(Modder $modder): EmptyResult
  {
    $stmt = $this->pdo->prepare('INSERT INTO modders VALUES (?, ?)');

    try {
      $stmt->execute([$modder->name, $modder->profileLink]);

      return EmptyResult::success();
    } catch (PDOException) {
      return EmptyResult::failure("Modder $modder->name ya existe");
    }
  }

  private function mapper(
    string $name,
    string $profileLink,
    string $profileImageLink
  ): Modder {
    return new Modder($name, $profileLink, $profileImageLink);
  }
}

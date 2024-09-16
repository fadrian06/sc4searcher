<?php

namespace SC4S\Repositories\Implementations\PDO;

use PDO;
use PDOException;
use SC4S\Models\Category;
use SC4S\Repositories\Interfaces\CategoryRepository;
use SC4S\Result\EmptyResult;

final readonly class PDOCategoryRepository implements CategoryRepository
{
  function __construct(private PDO $pdo) {}

  function getAll(): array
  {
    $stmt = $this->pdo->query('SELECT * FROM categories');
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_FUNC, [self::class, 'mapper']);
  }

  function getByName(string $categoryName): ?Category
  {
    $stmt = $this->pdo->prepare('SELECT * FROM categories WHERE name = ?');
    $stmt->execute([$categoryName]);
    $categoryArray = $stmt->fetch();

    if (!$categoryArray) {
      return null;
    }

    return self::mapper(
      $categoryArray['name'],
      $categoryArray['parent_category']
    );
  }

  function save(Category $category): EmptyResult
  {
    $stmt = $this->pdo->prepare('INSERT INTO categories VALUES (?, null)');

    try {
      $stmt->execute([$category->name]);

      return EmptyResult::success();
    } catch (PDOException) {
      return EmptyResult::failure("La categoría $category->name ya existe");
    }
  }

  function deleteByName(string $categoryName): EmptyResult
  {
    $stmt = $this->pdo->prepare('DELETE FROM categories WHERE name = ?');
    $stmt->execute([$categoryName]);

    return EmptyResult::success();
  }

  private static function mapper(
    string $categoryName,
    ?string $containerCategoryName = null
  ): Category {
    return new Category($categoryName);
  }
}

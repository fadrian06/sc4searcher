<?php

declare(strict_types=1);

function categoryMapper(array $category): array
{
  return [
    'name' => $category['name'],
    'parentCategory' => $category['parentCategory'],
    'subCategories' => getSubcategoriesOf($category['name']),
    'canBeDeleted' => checkIfCategoryCanBeDeleted($category),
    'plugins' => getPluginsByCategory($category['name'])
  ];
}

function db(): PDO
{
  static $pdo = null;

  if (!$pdo) {
    $pdo = new PDO(
      'sqlite:sc4searcher.db',
      options: [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
    );
  }

  return $pdo;
}

/** @return array<int, array<string, mixed>> */
function getRowsFromResult(
  SQLite3Result|PDOStatement $result,
  ?callable $mapper = null
): array {
  if ($result instanceof SQLite3Result) {
    while ($row = $result->fetchArray()) {
      $rows[] = $mapper ? $mapper($row) : $row;
    }

    return $rows ?? [];
  }

  foreach ($result as $row) {
    $rows[] = $mapper ? $mapper($row) : $row;
  }

  return $rows ?? [];
}

/** @return array<int, array<string, mixed>> */
function getRecordsFrom(string $table, ?callable $mapper = null): array
{
  $result = db()->query("SELECT * FROM $table");

  return getRowsFromResult($result, $mapper);
}

/** @return array<int, array{name: string, link: string}> */
function getModders(): array
{
  return getRecordsFrom('modders', fn (array $modder): array => [
    'name' => $modder['name'],
    'link' => str_ends_with($modder['link'], '/') ? $modder['link'] : "{$modder['link']}/"
  ]);
}

/** @return array<int, array{name: string}> */
function getGroups(): array
{
  return getRecordsFrom('groups');
}

function getSubcategoriesOf(string $parentCategory): array
{
  $query = 'SELECT name, parent_category as parentCategory FROM categories WHERE parent_category = :parentCategory';
  $stmt = db()->prepare($query);
  $stmt->bindValue(':parentCategory', $parentCategory);
  $stmt->execute();

  return getRowsFromResult($stmt, 'categoryMapper');
}

function getPluginsByCategory(string $category): array
{
  $query = <<<sql
    SELECT p.id as pluginId, p.name as pluginName, p.link as pluginLink,
    m.name as modderName, m.link as modderLink, c.name as categoryName,
    c.parent_category as categoryParentCategoryName, p.group_name as groupName
    FROM plugins p JOIN modders m JOIN categories c
    ON p.modder = m.name AND p.category = c.name
    WHERE p.category = :category
  sql;

  $stmt = db()->prepare($query);
  $stmt->bindValue(':category', $category);
  $stmt->execute();

  return getRowsFromResult($stmt, fn(array $plugin): array => [
    'id' => $plugin['pluginId'],
    'name' => $plugin['pluginName'],
    'link' => $plugin['pluginLink'],
    'modder' => [
      'name' => $plugin['modderName'],
      'link' => $plugin['modderLink']
    ],
    'category' => [
      'name' => $plugin['categoryName'],
      'parentCategory' => $plugin['categoryParentCategoryName']
    ],
    'groupName' => $plugin['groupName'],
    'dependencies' => getDependenciesOf($plugin['pluginId'])
  ]);
}

function checkIfCategoryCanBeDeleted(array $category): bool
{
  db()->beginTransaction();
  $stmt = db()->prepare('DELETE FROM categories WHERE name = :category');
  $stmt->bindValue(':category', $category['name']);
  $canBeDeleted = false;

  try {
    $stmt->execute();

    $canBeDeleted = true;
  } catch (PDOException) {
  }

  db()->rollBack();

  return $canBeDeleted;
}

/** @return array<int, array{name: string, parentCategory: string, subCategories: array<int, array{name: string, parentCategory: string}>}> */
function getCategories(): array
{
  $query = 'SELECT name, parent_category as parentCategory FROM categories';
  $result = db()->query($query);

  return getRowsFromResult($result, 'categoryMapper');
}

function getDependenciesOf(int $dependantId): array
{
  $query = <<<sql
    SELECT p.id as pluginId, p.name as pluginName, p.link as pluginLink,
    m.name as modderName, m.link as modderLink, c.name as categoryName,
    c.parent_category as categoryParentCategoryName, p.group_name as groupName
    FROM dependencies d JOIN plugins p JOIN modders m JOIN categories c
    ON p.modder = m.name AND p.category = c.name
    WHERE plugin_id = :dependantId
  sql;

  $stmt = db()->prepare($query);
  $stmt->bindValue(':dependantId', $dependantId);
  $stmt->execute();

  return array_filter(getRowsFromResult(
    $stmt,
    fn(array $plugin): array => [
      'id' => $plugin['pluginId'],
      'name' => $plugin['pluginName'],
      'link' => $plugin['pluginLink'],
      'modder' => [
        'name' => $plugin['modderName'],
        'link' => $plugin['modderLink']
      ],
      'category' => [
        'name' => $plugin['categoryName'],
        'parentCategory' => $plugin['categoryParentCategoryName']
      ],
      'groupName' => $plugin['groupName']
    ]
  ), fn(array $plugin): bool => $plugin['id'] !== $dependantId);
}

function getPlugins(): array
{
  $query = <<<sql
    SELECT p.id as pluginId, p.name as pluginName, p.link as pluginLink,
    m.name as modderName, m.link as modderLink, c.name as categoryName,
    c.parent_category as categoryParentCategoryName, p.group_name as groupName
    FROM plugins p JOIN modders m JOIN categories c
    ON p.modder = m.name AND p.category = c.name
  sql;

  $result = db()->query($query);

  return getRowsFromResult($result, fn(array $plugin): array => [
    'id' => $plugin['pluginId'],
    'name' => $plugin['pluginName'],
    'link' => $plugin['pluginLink'],
    'modder' => [
      'name' => $plugin['modderName'],
      'link' => $plugin['modderLink']
    ],
    'category' => [
      'name' => $plugin['categoryName'],
      'parentCategory' => $plugin['categoryParentCategoryName']
    ],
    'groupName' => $plugin['groupName'],
    'dependencies' => getDependenciesOf($plugin['pluginId'])
  ]);
}

/** @return ?array{name: string, parentCategory: string} */
function getCategoryByName(string $name): ?array
{
  $query = "SELECT name, parent_category as parentCategory FROM categories WHERE name = :name";
  $stmt = db()->prepare($query);
  $stmt->bindValue(':name', $name);
  $stmt->execute();
  $category = getRowsFromResult($stmt, 'categoryMapper')[0];

  return $category ?? null;
}

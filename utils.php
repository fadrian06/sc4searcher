<?php

declare(strict_types=1);

/** @return array<int, array<string, mixed>> */
function getRowsFromResult(
  SQLite3Result $result,
  ?callable $mapper = null
): array {
  while ($row = $result->fetchArray()) {
    $rows[] = $mapper ? $mapper($row) : $row;
  }

  return $rows ?? [];
}

/** @return array<int, array<string, mixed>> */
function getRecordsFrom(string $table): array
{
  $result = Flight::get('db')->query("SELECT * FROM $table");

  return getRowsFromResult($result);
}

/** @return array<int, array{name: string, link: string}> */
function getModders(): array
{
  return getRecordsFrom('modders');
}

/** @return array<int, array{name: string}> */
function getGroups(): array
{
  return getRecordsFrom('groups');
}

/** @return array<int, array{name: string, parentCategory: string}> */
function getCategories(): array
{
  $query = 'SELECT name, parent_category as parentCategory FROM categories';
  $result = Flight::get('db')->query($query);

  return getRowsFromResult($result);
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
  $result = Flight::get('db')->query($query);

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
    'groupName' => $plugin['groupName']
  ]);
}

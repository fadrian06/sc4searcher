<?php

namespace SC4S\Repositories\Implementations\PDO;

use DateTimeImmutable;
use PDO;
use SC4S\Models\Modder;
use SC4S\Models\Plugin;
use SC4S\Repositories\Interfaces\CategoryRepository;
use SC4S\Repositories\Interfaces\GroupRepository;
use SC4S\Repositories\Interfaces\ModderRepository;
use SC4S\Repositories\Interfaces\PluginRepository;
use SC4S\Result\EmptyResult;

final readonly class PDOPluginRepository implements PluginRepository
{
  function __construct(
    private PDO $pdo,
    private ModderRepository $modderRepository,
    private CategoryRepository $categoryRepository,
    private GroupRepository $groupRepository
  ) {}

  function getAll(): array
  {
    $stmt = $this->pdo->query('SELECT * FROM plugins');
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_FUNC, [$this, 'mapper']);
  }

  function getById(int $pluginId): ?Plugin
  {
    return null;
  }

  function getByModder(Modder $modder): array
  {
    $stmt = $this->pdo->query('SELECT * FROM plugins WHERE modder = ?');
    $stmt->execute([$modder->name]);

    return $stmt->fetchAll(PDO::FETCH_FUNC, [$this, 'mapper']);
  }

  function save(Plugin $plugin): EmptyResult
  {
    return EmptyResult::success();
  }

  function deleteById(int $pluginId): EmptyResult
  {
    return EmptyResult::success();
  }

  private function mapper(
    int $id,
    string $name,
    string $downloadPageLink,
    string $version,
    string $submittedDate,
    string $updatedDate,
    ?string $description,
    string $installation,
    ?string $sc4pacId,
    string $desinstallation,
    string $modderName,
    string $categoryName,
    ?string $groupName
  ): Plugin {
    return new Plugin(
      $id,
      $name,
      $downloadPageLink,
      $version,
      new DateTimeImmutable($submittedDate),
      new DateTimeImmutable($updatedDate),
      $installation,
      $desinstallation,
      $this->modderRepository->getByName($modderName),
      $this->categoryRepository->getByName($categoryName),
      $sc4pacId,
      $description,
      $groupName ? $this->groupRepository->getByName($groupName) : null,
      $this->getDependenciesById($id),
      $this->getImagesById($id)
    );
  }

  /** @return Plugin[] */
  private function getDependenciesById(int $id): array
  {
    return [];
  }

  /** @return string[] */
  private function getImagesById(int $id): array
  {
    $stmt = $this->pdo->prepare('SELECT image_link FROM plugin_images WHERE plugin_id = ?');
    $stmt->execute([$id]);

    return $stmt->fetchAll(PDO::FETCH_FUNC, fn(string $imageLink): string => $imageLink);
  }
}

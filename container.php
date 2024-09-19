<?php

use Illuminate\Container\Container;
use Psr\Container\ContainerInterface;
use SC4S\Repositories\Implementations\PDO\PDOCategoryRepository;
use SC4S\Repositories\Implementations\PDO\PDOGroupRepository;
use SC4S\Repositories\Implementations\PDO\PDOModderRepository;
use SC4S\Repositories\Implementations\PDO\PDOPluginRepository;
use SC4S\Repositories\Interfaces\CategoryRepository;
use SC4S\Repositories\Interfaces\GroupRepository;
use SC4S\Repositories\Interfaces\ModderRepository;
use SC4S\Repositories\Interfaces\PluginRepository;

$container = new Container;

$container->bind(PDO::class, fn(): PDO => new PDO(
  'sqlite:sc4searcher.db',
  options: [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
), true);

$container->bind(CategoryRepository::class, PDOCategoryRepository::class, true);
$container->bind(GroupRepository::class, PDOGroupRepository::class, true);
$container->bind(PluginRepository::class, PDOPluginRepository::class, true);
$container->bind(ModderRepository::class, PDOModderRepository::class, true);

Flight::registerContainerHandler([$container, 'get']);

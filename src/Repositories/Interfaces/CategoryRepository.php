<?php

namespace SC4S\Repositories\Interfaces;

use SC4S\Models\Category;
use SC4S\Result\EmptyResult;

interface CategoryRepository
{
  /** @return Category[] */
  function getAll(): array;
  function getByName(string $categoryName): ?Category;
  function save(Category $category): EmptyResult;
  function deleteByName(string $categoryName): EmptyResult;
}

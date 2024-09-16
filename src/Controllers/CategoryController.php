<?php

namespace SC4S\Controllers;

use Flight;
use SC4S\Exceptions\ResourceNotFound;
use SC4S\Models\Category;
use SC4S\Repositories\Interfaces\CategoryRepository;

final readonly class CategoryController
{
  function __construct(private CategoryRepository $repository) {}

  function showCategories(): void
  {
    Flight::render('pages/categories/list', ['categories' => $this->repository->getAll()], 'page');
    Flight::render('layouts/base', ['title' => 'Categorías']);
  }

  function showCategory(string $categoryName): void
  {
    $category = $this->repository->getByName($categoryName) ?? throw new ResourceNotFound("La categoría $categoryName no ha sido registrada");

    Flight::render('pages/categories/details', compact('category'), 'page');
    Flight::render('layouts/base', ['title' => $categoryName]);
  }

  function deleteCategory(string $categoryName): void
  {
    $this->repository->deleteByName($categoryName);
    Flight::redirect('/categorias');
  }

  function addCategory(): void
  {
    $categoryCollection = Flight::request()->data;
    $category = new Category($categoryCollection->name);
    $result = $this->repository->save($category);

    if (!$result->wasSuccessfully()) {
      Flight::redirect("/categorias?error=$result->error");
    } else {
      Flight::redirect(Flight::request()->referrer);
    }
  }
}

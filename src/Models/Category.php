<?php

namespace SC4S\Models;

final readonly class Category
{
  /** @var self[] */
  public array $subcategories;

  /** @var Plugin[] */
  public array $plugins;

  function __construct(
    public string $name,
    public ?self $parentCategory = null
  ) {
    $this->subcategories = [];
    $this->plugins = [];
  }

  function isSubcategory(): bool
  {
    return $this->parentCategory !== null;
  }

  function hasSubcategories(): bool
  {
    return $this->subcategories !== [];
  }

  function hasPlugins(): bool
  {
    return $this->plugins !== [];
  }
}

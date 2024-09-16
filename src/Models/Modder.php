<?php

namespace SC4S\Models;

final readonly class Modder
{
  /** @param Plugin[] $plugins */
  function __construct(
    public string $name,
    public string $profileLink,
    private array $plugins,
  ) {}

  function hasPlugins(): bool
  {
    return $this->plugins !== [];
  }
}

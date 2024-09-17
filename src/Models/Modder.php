<?php

namespace SC4S\Models;

final readonly class Modder
{
  public string $profileLink;

  /** @param Plugin[] $plugins */
  function __construct(
    public readonly string $name,
    string $profileLink,
    public string $profileImageLink,
    private array $plugins = [],
  ) {
    $this->profileLink = str_ends_with($profileLink, '/')
      ? $profileLink
      : "$profileLink/";
  }

  function hasPlugins(): bool
  {
    return $this->plugins !== [];
  }
}

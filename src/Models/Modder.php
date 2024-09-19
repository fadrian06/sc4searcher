<?php

namespace SC4S\Models;

final class Modder
{
  public readonly string $profileLink;

  /** @var Plugin[] */
  private array $plugins = [];

  /** @param Plugin[] $plugins */
  function __construct(
    public readonly string $name,
    string $profileLink,
    public readonly string $profileImageLink
  ) {
    $this->profileLink = str_ends_with($profileLink, '/')
      ? $profileLink
      : "$profileLink/";
  }

  function hasPlugins(): bool
  {
    return $this->plugins !== [];
  }

  function setPlugins(Plugin ...$plugins): self
  {
    $this->plugins = $plugins;

    return $this;
  }

  /** @return Plugin[] */
  function getPlugins(): array
  {
    return $this->plugins;
  }
}

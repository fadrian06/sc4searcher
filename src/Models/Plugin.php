<?php

namespace SC4S\Models;

use DateTimeInterface;

final readonly class Plugin
{
  /** @param self[] $dependencies */
  function __construct(
    public int $id,
    public string $name,
    public string $downloadPageLink,
    public string $version,
    public DateTimeInterface $submittedDate,
    public DateTimeInterface $updatedDate,
    public string $installation,
    public string $desinstallation,
    public Modder $modder,
    public Category $category,
    public ?string $sc4pacId = null,
    public ?string $description = null,
    public ?Group $group = null,
    public array $dependencies = []
  ) {}

  function hasDependencies(): bool
  {
    return $this->dependencies !== [];
  }
}

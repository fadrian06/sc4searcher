<?php

namespace SC4S\Models;

final readonly class Plugin
{
  function __construct(
    private string $name,
    private string $version,
    private Modder $modder,
  ) {}
}

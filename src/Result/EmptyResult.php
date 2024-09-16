<?php

namespace SC4S\Result;

/** @extends Result<null> */
final readonly class EmptyResult extends Result
{
  static function success(mixed $value = null): self
  {
    return new self(null);
  }
}

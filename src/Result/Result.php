<?php

namespace SC4S\Result;

/** @template T of mixed */
abstract readonly class Result
{
  /** @param T $value */
  final protected function __construct(
    public mixed $value,
    public ?string $error = null
  ) {}

  /**
   * @param T $value
   * @return self<T>
   */
  static function success(mixed $value): self
  {
    return new self($value);
  }

  /** @return self<null> */
  final static function failure(string $error): static
  {
    return new static(null, $error);
  }

  final function wasSuccessfully(): bool
  {
    return $this->error === null;
  }
}

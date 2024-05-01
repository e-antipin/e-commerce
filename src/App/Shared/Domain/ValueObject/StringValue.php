<?php

declare(strict_types=1);

namespace App\Shared\Domain\ValueObject;

abstract class StringValue implements \Stringable
{
    public function __construct(protected string $value)
    {
    }

    final public function value(): string
    {
        return $this->value;
    }
    final public function __toString(): string
    {
        return $this->value;
    }
}
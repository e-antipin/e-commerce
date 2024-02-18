<?php

declare(strict_types=1);

namespace App\Shared\Domain\ValueObject;

use \Symfony\Component\Uid\Uuid as SymfonyUuid;
abstract class UUID
{
    final public function __construct(protected string $value)
    {
        $this->isValid($value);
    }

    final public static function new(): self
    {
        return new static(SymfonyUuid::v7()->toBinary());
    }

    final public function value(): string
    {
        return $this->value;
    }

    final public function equals(self $other): bool
    {
        return $this->value() === $other->value();
    }

    public function __toString(): string
    {
        return $this->value();
    }

    private function isValid(string $id): void
    {
        if (!SymfonyUuid::isValid($id)) {
            throw new \InvalidArgumentException(sprintf('<%s> does not allow the value <%s>.', self::class, $id));
        }
    }}
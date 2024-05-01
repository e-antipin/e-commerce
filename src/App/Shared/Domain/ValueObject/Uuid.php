<?php

declare(strict_types=1);

namespace App\Shared\Domain\ValueObject;

use Symfony\Component\Uid\Uuid as SymfonyUuid;

class Uuid
{
    final public function __construct(protected string $value)
    {
        $this->isValid($value);
    }

    final public static function new(): self
    {
        return new static(SymfonyUuid::v7()->toRfc4122());
    }

    final public static function fromBytes(string $value): self
    {
        return new static(SymfonyUuid::fromBase32($value)->toRfc4122());
    }

    final public function toBytes(): string
    {
        return SymfonyUuid::fromRfc4122($this->value)->toBase32();
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
    }
}

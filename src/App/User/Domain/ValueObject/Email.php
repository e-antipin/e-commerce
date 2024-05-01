<?php

declare(strict_types=1);

namespace App\User\Domain\ValueObject;

use Webmozart\Assert\Assert;
use Webmozart\Assert\InvalidArgumentException;

final class Email implements \Stringable
{
    private function __construct(private readonly string $value)
    {
    }

    /**
     * @throws InvalidArgumentException
     */
    public static function fromString(string $email): self
    {
        Assert::email($email, 'Not a valid email');

        return new self($email);
    }

    public function toString(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}

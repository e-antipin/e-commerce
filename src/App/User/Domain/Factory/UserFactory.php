<?php

declare(strict_types=1);

namespace App\User\Domain\Factory;

use App\Shared\Domain\Exception\DateTimeException;
use App\Shared\Domain\ValueObject\Uuid;
use App\User\Domain\Aggregate\User;
use App\User\Domain\Specification\UniqueEmailSpecificationInterface;
use App\User\Domain\ValueObject\Credentials;

class UserFactory
{
    public function __construct(private readonly UniqueEmailSpecificationInterface $uniqueEmailSpecification)
    {
    }

    /**
     * @throws DateTimeException
     */
    public function create(Uuid $uuid, Credentials $credentials): User
    {
        return User::create($uuid, $credentials, $this->uniqueEmailSpecification);
    }
}

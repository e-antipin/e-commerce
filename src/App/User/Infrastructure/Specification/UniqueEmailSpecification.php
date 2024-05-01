<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Specification;

use App\User\Domain\Specification\UniqueEmailSpecificationInterface;
use App\User\Domain\ValueObject\Email;
use App\User\Infrastructure\Repository\UserRepository;
use Webmozart\Assert\Assert;

final class UniqueEmailSpecification implements UniqueEmailSpecificationInterface
{
    public function __construct(private readonly UserRepository $userRepository)
    {
    }

    public function isUnique(Email $email): void
    {
        Assert::isEmpty($this->userRepository->findByEmail($email));
    }
}

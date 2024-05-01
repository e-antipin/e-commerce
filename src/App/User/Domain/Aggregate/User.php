<?php

declare(strict_types=1);

namespace App\User\Domain\Aggregate;

use App\Shared\Domain\Aggregate\AggregateRoot;
use App\Shared\Domain\Exception\DateTimeException;
use App\Shared\Domain\ValueObject\DateTime;
use App\Shared\Domain\ValueObject\Uuid;
use App\User\Domain\Event\UserWasCreated;
use App\User\Domain\Specification\UniqueEmailSpecificationInterface;
use App\User\Domain\ValueObject\Credentials;
use App\User\Domain\ValueObject\Email;
use App\User\Domain\ValueObject\HashedPassword;

class User extends AggregateRoot
{
    private Uuid $uuid;

    private Email $email;

    private HashedPassword $hashedPassword;

    private DateTime $createdAt;

    private ?DateTime $updatedAt = null;

    private function __construct(Uuid $uuid, Email $email, HashedPassword $hashedPassword)
    {
        $this->uuid = $uuid;
        $this->email = $email;
        $this->hashedPassword = $hashedPassword;
    }

    /**
     * @throws DateTimeException
     */
    public static function create(
        Uuid $uuid,
        Credentials $credentials,
        UniqueEmailSpecificationInterface $uniqueEmailSpecification
    ): self {
        $uniqueEmailSpecification->isUnique($credentials->email);

        $user = new self(
            $uuid,
            $credentials->email,
            $credentials->password
        );
        $user->createdAt = DateTime::now();
        $user->updatedAt = DateTime::now();

        $user->record(new UserWasCreated($uuid->value()));

        return $user;
    }

    public function uuid(): string
    {
        return $this->uuid->value();
    }

    public function email(): string
    {
        return $this->email->toString();
    }

    public function createdAt(): ?string
    {
        return isset($this->createdAt) ? $this->createdAt->toString() : null;
    }

    public function updatedAt(): ?string
    {
        return $this->updatedAt->toString();
    }
}

<?php

declare(strict_types=1);

namespace App\User\Domain\Entity;


use App\Shared\Domain\ValueObject\DateTime;
use App\User\Domain\ValueObject\Credentials;
use App\User\Domain\ValueObject\Email;
use App\User\Domain\ValueObject\HashedPassword;
use Symfony\Component\Uid\Uuid;

class User
{
    private Uuid $uuid;

    private Email $email;

    private HashedPassword $hashedPassword;

    private ?DateTime $createdAt = null;

    private ?DateTime $updatedAt = null;

    private function __construct(){}

    public static function create(Credentials $credentials): self
    {
        $user = new self();
        $user->uuid = Uuid::v7();
        $user->email = $credentials->email;
        $user->hashedPassword = $credentials->password;
        $user->createdAt = DateTime::now();

        return $user;
    }

    public function getUuid(): string
    {
        return $this->uuid->toRfc4122();
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getHashedPassword(): HashedPassword
    {
        return $this->hashedPassword;
    }

    public function getCreatedAt(): ?DateTime
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?DateTime
    {
        return $this->updatedAt;
    }
}
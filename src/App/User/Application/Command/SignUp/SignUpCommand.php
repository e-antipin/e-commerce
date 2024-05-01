<?php

declare(strict_types=1);

namespace App\User\Application\Command\SignUp;

use App\Shared\Application\Command\CommandInterface;
use App\Shared\Domain\ValueObject\Uuid;
use App\User\Domain\ValueObject\Credentials;
use App\User\Domain\ValueObject\Email;
use App\User\Domain\ValueObject\HashedPassword;

final class SignUpCommand implements CommandInterface
{
    /** @psalm-readonly */
    public Uuid $uuid;

    /** @psalm-readonly */
    public Credentials $credentials;

    public function __construct(string $uuid, string $email, string $plainPassword)
    {
        $this->uuid = new Uuid($uuid);
        $this->credentials = new Credentials(Email::fromString($email), HashedPassword::toHash($plainPassword));
    }
}

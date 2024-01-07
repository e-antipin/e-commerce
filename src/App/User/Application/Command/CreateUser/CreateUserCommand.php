<?php

declare(strict_types=1);

namespace App\User\Application\Command\CreateUser;

use App\Shared\Application\Command\CommandInterface;
use App\User\Domain\ValueObject\Credentials;

class CreateUserCommand implements CommandInterface
{
    public function __construct(public readonly Credentials $credentials)
    {

    }
}
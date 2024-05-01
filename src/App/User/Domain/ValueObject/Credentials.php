<?php

declare(strict_types=1);

namespace App\User\Domain\ValueObject;

class Credentials
{
    public function __construct(public Email $email, public HashedPassword $password)
    {
    }
}

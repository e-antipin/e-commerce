<?php

declare(strict_types=1);

namespace App\User\Application\Event\UserCreate;

use App\Shared\Application\Event\EventHandlerInterface;
use App\User\Domain\Event\UserWasCreated;

class UserWasCreatedEventListener implements EventHandlerInterface
{
    public function __invoke(UserWasCreated $event): void
    {
    }
}

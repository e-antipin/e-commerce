<?php

namespace App\Shared\Domain\Event;

interface EventDispatcher
{
    public function dispatch(DomainEvent ...$events): void;
}

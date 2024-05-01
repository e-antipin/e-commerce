<?php

declare(strict_types=1);

namespace App\Shared\Domain\Aggregate;

use App\Shared\Domain\Event\DomainEvent;

abstract class AggregateRoot
{
    /** @var array<DomainEvent> */
    private array $domainEvents = [];

    /**
     * @return array<DomainEvent> $domainEvents
     */
    final public function releaseEvents(): array
    {
        $domainEvents = $this->domainEvents;
        $this->domainEvents = [];

        return $domainEvents;
    }

    final public function domainEventsEmpty(): bool
    {
        return empty($this->domainEvents);
    }

    final protected function record(DomainEvent $domainEvent): void
    {
        $this->domainEvents[] = $domainEvent;
    }
}

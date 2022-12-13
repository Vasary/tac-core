<?php

declare(strict_types=1);

namespace App\Application\DomainEvent\Persistence;

use App\Domain\Event\EventInterface;
use Generator;

final class EventStore
{
    public function __construct(private array $events = [])
    {
    }

    public function add(EventInterface $event): void
    {
        $this->events[spl_object_hash($event)] = $event;
    }

    public function dequeue(): Generator
    {
        while ($event = array_shift($this->events)) {
            yield $event;
        }
    }

    public function isEmpty(): bool
    {
        return 0 === count($this->events);
    }
}

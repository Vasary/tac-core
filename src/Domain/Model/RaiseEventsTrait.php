<?php

declare(strict_types=1);

namespace App\Domain\Model;

use App\Domain\Event\EventInterface;

trait RaiseEventsTrait
{
    protected array $events = [];

    public function popEvents(): array
    {
        $events = $this->events;

        $this->events = [];

        return $events;
    }

    protected function raise(EventInterface $event): void
    {
        $this->events[] = $event;
    }
}

<?php

declare(strict_types = 1);

namespace App\Application\DomainEvent\Business\EventsLogReader;

final class Log
{
    public function __construct(
        private readonly string $destinationStamp,
        private readonly string $event,
    ) {
    }

    public function destinationStamp(): string
    {
        return $this->destinationStamp;
    }

    public function event(): string
    {
        return $this->event;
    }
}

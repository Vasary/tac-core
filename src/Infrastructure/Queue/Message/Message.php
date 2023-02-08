<?php

declare(strict_types = 1);

namespace App\Infrastructure\Queue\Message;

final class Message
{
    public function __construct(
        private readonly string $event,
        private readonly string $destinationStamp
    ) {
    }

    public function getEvent(): string
    {
        return $this->event;
    }

    public function getDestinationStamp(): string
    {
        return $this->destinationStamp;
    }
}

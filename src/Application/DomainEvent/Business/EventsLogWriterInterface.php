<?php

declare(strict_types = 1);

namespace App\Application\DomainEvent\Business;

interface EventsLogWriterInterface
{
    public function write(string $event, string $destinationStamp): void;
}

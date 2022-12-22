<?php

namespace App\Application\DomainEvent\Business;

interface EventsLogWriterInterface
{
    public function write(string $event, string $destinationStamp): void;
}

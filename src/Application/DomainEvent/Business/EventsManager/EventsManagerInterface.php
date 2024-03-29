<?php

declare(strict_types = 1);

namespace App\Application\DomainEvent\Business\EventsManager;

interface EventsManagerInterface
{
    public function replay(): void;

    public function publish(string $event, string $destination): void;
}

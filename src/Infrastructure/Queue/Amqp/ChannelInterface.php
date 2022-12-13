<?php

declare(strict_types=1);

namespace App\Infrastructure\Queue\Amqp;

interface ChannelInterface
{
    public function isOpen(): bool;

    public function publish(string $body, string $routingKey): void;
}

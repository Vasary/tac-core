<?php

declare(strict_types=1);

namespace App\Infrastructure\Queue\Amqp;

final class NullChannel implements ChannelInterface
{
    public function isOpen(): bool
    {
        return true;
    }

    public function publish(string $body, string $routingKey): void
    {
    }
}

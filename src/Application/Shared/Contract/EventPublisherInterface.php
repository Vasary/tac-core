<?php

declare(strict_types=1);

namespace App\Application\Shared\Contract;

use App\Infrastructure\Queue\Message\Message;

interface EventPublisherInterface
{
    public function publish(Message $message): void;
}

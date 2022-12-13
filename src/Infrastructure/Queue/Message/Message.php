<?php

declare(strict_types=1);

namespace App\Infrastructure\Queue\Message;

final class Message
{
    public function __construct(
        private readonly object $event
    ) {
    }

    public function getEvent(): object
    {
        return $this->event;
    }

    public function getName(): string
    {
        $class = explode('\\', get_class($this->event));
        end($class);

        return strtolower(preg_replace('/(?<!^)[A-Z]/', '.$0', current($class)));
    }
}

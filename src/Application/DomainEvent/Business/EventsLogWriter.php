<?php

declare(strict_types=1);

namespace App\Application\DomainEvent\Business;

final class EventsLogWriter implements EventsLogWriterInterface
{
    public function __construct(
        private readonly string $filePath
    )
    {
    }

    public function write(string $event, string $destinationStamp): void
    {
        $data = $destinationStamp . ',' . $event . PHP_EOL;

        file_put_contents($this->filePath, $data, FILE_APPEND | LOCK_EX);
    }
}

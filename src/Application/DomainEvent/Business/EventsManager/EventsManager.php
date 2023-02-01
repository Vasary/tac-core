<?php

declare(strict_types=1);

namespace App\Application\DomainEvent\Business\EventsManager;

use App\Application\DomainEvent\Business\EventsLogReader\EventsLogReaderInterface;
use App\Application\DomainEvent\Business\EventsLogWriterInterface;
use App\Application\Shared\Contract\EventPublisherInterface;
use App\Infrastructure\Queue\Message\Message;

final class EventsManager implements EventsManagerInterface
{
    public function __construct(
        private readonly EventPublisherInterface  $eventPublisher,
        private readonly EventsLogReaderInterface $reader,
        private readonly EventsLogWriterInterface $logWriter,
    )
    {
    }

    public function replay(): void
    {
        uopz_allow_exit(true);

        foreach ($this->reader as $event) {
            if (null !== $event) {
                try {
                    $this->eventPublisher->publish(new Message($event->event(), $event->destinationStamp()));
                } catch (\Throwable $throwable) {
                    dd($event);
                }
            }
        }
    }

    public function publish(string $event, string $destination): void
    {
        $this->eventPublisher->publish(new Message($event, $destination));
        $this->logWriter->write($event, $destination);
    }
}

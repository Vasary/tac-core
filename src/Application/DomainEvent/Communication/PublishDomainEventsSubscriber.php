<?php

declare(strict_types=1);

namespace App\Application\DomainEvent\Communication;

use App\Application\DomainEvent\Persistence\EventStore;
use App\Application\Shared\Contract\EventPublisherInterface;
use App\Infrastructure\Queue\Message\Message;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

final class PublishDomainEventsSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private readonly EventStore              $eventStore,
        private readonly EventPublisherInterface $publisher,
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::RESPONSE => [
                ['publishEvents', 9],
            ],
        ];
    }

    public function publishEvents(ResponseEvent $event): void
    {
        if (!$event->getResponse()->isSuccessful()) {
            return;
        }

        foreach ($this->eventStore->dequeue() as $event) {
            $this->publisher->publish(new Message($event));
        }
    }
}

<?php

declare(strict_types = 1);

namespace App\Application\DomainEvent\Communication\Subscriber;

use App\Application\DomainEvent\Business\EventsManager\EventsManagerInterface;
use App\Application\DomainEvent\Persistence\EventStore;
use App\Infrastructure\Serializer\Serializer;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

final class DomainEventsSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private readonly EventStore $eventStore,
        private readonly EventsManagerInterface $eventsManager,
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
            $destinationStamp = $this->getRoutingKey($event);
            $serializedEvent = Serializer::create()->toJson($event);

            $this->eventsManager->publish($serializedEvent, $destinationStamp);
        }
    }

    private function getRoutingKey(object $event): string
    {
        $class = explode('\\', get_class($event));
        end($class);

        return strtolower(preg_replace('/(?<!^)[A-Z]/', '.$0', current($class)));
    }
}

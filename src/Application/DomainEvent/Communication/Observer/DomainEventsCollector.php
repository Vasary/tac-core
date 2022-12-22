<?php

declare(strict_types=1);

namespace App\Application\DomainEvent\Communication\Observer;

use App\Application\DomainEvent\Persistence\EventStore;
use App\Domain\Model\RaiseEventsInterface;
use Doctrine\Bundle\DoctrineBundle\EventSubscriber\EventSubscriberInterface;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;

final class DomainEventsCollector implements EventSubscriberInterface
{
    public function __construct(
        private readonly EventStore $eventStore
    ) {
    }

    public function postPersist(LifecycleEventArgs $event): void
    {
        $this->doCollect($event);
    }

    public function postUpdate(LifecycleEventArgs $event): void
    {
        $this->doCollect($event);
    }

    public function preRemove(LifecycleEventArgs $event): void
    {
        $this->doCollect($event);
    }

    public function postRemove(LifecycleEventArgs $event): void
    {
        $this->doCollect($event);
    }

    public function getSubscribedEvents(): array
    {
        return [
            Events::postPersist,
            Events::postUpdate,
            Events::preRemove,
            Events::postRemove,
        ];
    }

    private function doCollect(LifecycleEventArgs $event): void
    {
        $entity = $event->getObject();

        if (!$entity instanceof RaiseEventsInterface) {
            return;
        }

        foreach ($entity->popEvents() as $event) {
            $this->eventStore->add($event);
        }
    }
}

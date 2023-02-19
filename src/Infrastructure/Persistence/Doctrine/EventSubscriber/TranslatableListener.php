<?php

declare(strict_types = 1);

namespace App\Infrastructure\Persistence\Doctrine\EventSubscriber;

use App\Domain\Model\Attribute;
use App\Infrastructure\Persistence\Doctrine\Adapter\TranslationAdapter;
use Doctrine\Bundle\DoctrineBundle\EventSubscriber\EventSubscriberInterface;
use Doctrine\Common\Proxy\Proxy;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\OnFlushEventArgs;
use Doctrine\ORM\Events;
use ReflectionClass;

final class TranslatableListener implements EventSubscriberInterface
{
    public function __construct(private readonly TranslationAdapter $adapter,) {
    }

    public function getSubscribedEvents(): array
    {
        return [
            Events::postLoad,
            Events::onFlush,
        ];
    }

    public function onFlush(OnFlushEventArgs $args): void
    {
        $objectManager = $args->getObjectManager();

        foreach ($args->getObjectManager()->getUnitOfWork()->getScheduledEntityInsertions() as $insertion) {
            $reflection = new ReflectionClass($insertion);

            foreach ($reflection->getProperties() as $property) {
                if ($this->adapter->isPropertyTranslatable($property)) {
                    $this->adapter->upsertTranslation($property, $insertion, $objectManager);
                }
            }
        }

        foreach ($args->getObjectManager()->getUnitOfWork()->getScheduledEntityUpdates() as $update) {
            $reflection = new ReflectionClass($update);

            foreach ($reflection->getProperties() as $property) {
                if ($this->adapter->isPropertyTranslatable($property)) {
                    $this->adapter->upsertTranslation($property, $update, $objectManager);
                }
            }
        }
    }

    public function postLoad(LifecycleEventArgs $args): void
    {
        $entityManager = $args->getObjectManager();
        $object = $args->getObject();

        $reflection = new ReflectionClass($object);

        foreach ($reflection->getProperties() as $property) {
            if ($this->adapter->isPropertyTranslatable($property)) {
                $this->adapter->setTranslation($property, $object, $entityManager);
            }
        }
    }
}

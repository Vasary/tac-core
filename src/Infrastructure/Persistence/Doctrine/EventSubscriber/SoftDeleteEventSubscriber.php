<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\EventSubscriber;

use DateTimeImmutable;
use Doctrine\ORM\Event\OnFlushEventArgs;

final class SoftDeleteEventSubscriber extends AbstractEventSubscriber
{
    private const SOFT_DELETE_FIELD_NAME = 'deletedAt';

    public function onFlush(OnFlushEventArgs $args): void
    {
        $unitOfWork = $args->getObjectManager()->getUnitOfWork();
        $objectManager = $args->getObjectManager();
        $platform = $objectManager->getConnection()->getDriver()->getDatabasePlatform();

        foreach ($unitOfWork->getScheduledEntityDeletions() as $object) {
            $metaData = $objectManager->getClassMetadata($object::class);

            if (!$metaData->hasField(self::SOFT_DELETE_FIELD_NAME)) {
                continue;
            }

            $reflectedProperty = $metaData->getReflectionProperty(self::SOFT_DELETE_FIELD_NAME);

            $currentValue = $reflectedProperty->getValue($object);
            $deletedAtDate =
                $this
                    ->getDateTimeImmutableType()
                    ->convertToPHPValue(new DateTimeImmutable(), $platform)
            ;

            $reflectedProperty->setValue($object, $deletedAtDate);

            $objectManager->persist($object);

            $unitOfWork->scheduleExtraUpdate($object, [
                self::SOFT_DELETE_FIELD_NAME => [$currentValue, $deletedAtDate],
            ]);
        }
    }
}

<?php

declare(strict_types = 1);

namespace App\Infrastructure\Persistence\Doctrine\EventSubscriber;

use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Types\Types;

abstract class AbstractEventSubscriber
{
    protected function getDateTimeImmutableType(): Type
    {
        return Type::getType(Types::DATETIMETZ_IMMUTABLE);
    }
}

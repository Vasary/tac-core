<?php

declare(strict_types = 1);

namespace App\Infrastructure\Persistence\Doctrine\Type;

use App\Domain\Factory\TypeFactory;
use App\Domain\Model\Attribute\Type\AbstractType;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

final class ValueTypeType extends Type
{
    private const NAME = 'type';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getStringTypeDeclarationSQL($column);
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function convertToDatabaseValue(mixed $value, AbstractPlatform $platform): string
    {
        return (string) $value;
    }

    public function convertToPHPValue(mixed $value, AbstractPlatform $platform): AbstractType
    {
        return TypeFactory::create($value);
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }
}

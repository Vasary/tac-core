<?php

declare(strict_types = 1);

namespace App\Domain\Factory;

use App\Domain\Model\Attribute\Type\AbstractType;
use App\Domain\Model\Attribute\Type\ArrayType;
use App\Domain\Model\Attribute\Type\BooleanType;
use App\Domain\Model\Attribute\Type\FloatType;
use App\Domain\Model\Attribute\Type\IntegerType;
use App\Domain\Model\Attribute\Type\StringType;

final class TypeFactory
{
    public const TYPE_ARRAY = 'array';
    public const TYPE_FLOAT = 'float';
    public const TYPE_INTEGER = 'integer';
    public const TYPE_STRING = 'string';
    public const TYPE_BOOLEAN = 'boolean';

    public static function create(string $type): AbstractType
    {
        return match ($type) {
            self::TYPE_ARRAY => new ArrayType(),
            self::TYPE_FLOAT => new FloatType(),
            self::TYPE_INTEGER => new IntegerType(),
            self::TYPE_STRING => new StringType(),
            self::TYPE_BOOLEAN => new BooleanType(),
        };
    }
}

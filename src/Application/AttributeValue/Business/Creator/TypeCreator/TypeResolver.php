<?php

declare(strict_types=1);

namespace App\Application\AttributeValue\Business\Creator\TypeCreator;

final class TypeResolver
{
    public function __construct(
        private readonly ArrayCreator   $arrayCreator,
        private readonly BooleanCreator $booleanCreator,
        private readonly IntegerCreator $integerCreator,
        private readonly StringCreator  $stringCreator,
        private readonly FloatCreator   $floatCreator
    ) {
    }

    public function resolve(string $type): AttributeCreatorInterface
    {
        return match ($type) {
            'array' => $this->arrayCreator,
            'string' => $this->stringCreator,
            'boolean' => $this->booleanCreator,
            'integer' => $this->integerCreator,
            'float' => $this->floatCreator,
        };
    }
}

<?php

declare(strict_types=1);

namespace App\Domain\Model\AttributeValue;

final class Value
{
    public function __construct(private readonly ?string $value)
    {
    }

    public function getValue(): ?string
    {
        return $this->value;
    }
}

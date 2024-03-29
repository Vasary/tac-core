<?php

declare(strict_types = 1);

namespace App\Domain\ValueObject;

final class Uuid
{
    public function __construct(private readonly string $value)
    {
    }

    public function __toString(): string
    {
        return $this->value;
    }
}

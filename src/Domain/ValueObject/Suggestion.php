<?php

declare(strict_types = 1);

namespace App\Domain\ValueObject;

final class Suggestion
{
    public function __construct(
        private readonly int $value
    ) {
    }

    public function getValue(): int
    {
        return $this->value;
    }
}

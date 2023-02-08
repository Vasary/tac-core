<?php

declare(strict_types = 1);

namespace App\Domain\ValueObject;

final class I18N
{
    public function __construct(
        private readonly ?string $value
    ) {
    }

    public function value(): ?string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return (string)$this->value;
    }
}

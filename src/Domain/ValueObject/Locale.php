<?php

declare(strict_types = 1);

namespace App\Domain\ValueObject;

use Stringable;

final class Locale implements Stringable
{
    public function __construct(private readonly string $locale)
    {
    }

    public function __toString(): string
    {
        return $this->locale;
    }
}

<?php

declare(strict_types = 1);

namespace App\Domain\Model\AttributeValue;

use Stringable;

final class Code implements Stringable
{
    public function __construct(private readonly string $code)
    {
    }

    public function __toString(): string
    {
        return $this->code;
    }
}

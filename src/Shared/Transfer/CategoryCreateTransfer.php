<?php

declare(strict_types = 1);

namespace App\Shared\Transfer;

final class CategoryCreateTransfer
{
    use CreateFromTrait;

    public function __construct(private readonly string $name)
    {
    }

    public function getName(): string
    {
        return $this->name;
    }
}

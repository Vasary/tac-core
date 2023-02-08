<?php

declare(strict_types = 1);

namespace App\Shared\Transfer;

final class UpdateCategoryTransfer
{
    use CreateFromTrait;

    public function __construct(
        private readonly string $id,
        private readonly string $name,
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }
}

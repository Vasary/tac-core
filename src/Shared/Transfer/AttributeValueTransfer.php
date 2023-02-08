<?php

declare(strict_types = 1);

namespace App\Shared\Transfer;

final class AttributeValueTransfer
{
    use CreateFromTrait;

    public function __construct(
        private readonly mixed $value,
        private readonly string $id,
        private readonly ?string $parent = null,
    ) {
    }

    public function getValue(): mixed
    {
        return $this->value;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getParent(): ?string
    {
        return $this->parent;
    }
}

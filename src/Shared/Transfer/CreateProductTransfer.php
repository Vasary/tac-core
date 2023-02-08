<?php

declare(strict_types = 1);

namespace App\Shared\Transfer;

final class CreateProductTransfer
{
    use CreateFromTrait;

    public function __construct(
        private readonly string $name,
        private readonly string $description,
        private readonly string $category,
        /** @param AttributeValueTransfer[]|null $attributes */
        private readonly ?array $attributes = null,
        /** @param string[]|null $units */
        private readonly ?array $units = null,
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getCategory(): string
    {
        return $this->category;
    }

    /**
     * @return AttributeValueTransfer[]|null
     */
    public function getAttributes(): ?array
    {
        return $this->attributes;
    }

    /**
     * @return string[]|null
     */
    public function getUnits(): ?array
    {
        return $this->units;
    }
}

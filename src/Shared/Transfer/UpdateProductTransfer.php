<?php

declare(strict_types = 1);

namespace App\Shared\Transfer;

final class UpdateProductTransfer
{
    use CreateFromTrait;

    public function __construct(
        /** @param AttributeValueTransfer[] $attributes */
        private readonly array $attributes,
        private readonly string $id,
        private readonly ?string $name = null,
        private readonly ?string $description = null,
        /** @param string[]|null $units */
        private readonly ?array $units = null,
    ) {
    }

    /**
     * @return AttributeValueTransfer[]
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @return string[]|null
     */
    public function getUnits(): ?array
    {
        return $this->units;
    }
}

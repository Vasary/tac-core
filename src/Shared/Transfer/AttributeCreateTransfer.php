<?php

declare(strict_types = 1);

namespace App\Shared\Transfer;

final class AttributeCreateTransfer
{
    use CreateFromTrait;

    public function __construct(
        private readonly string $code,
        private readonly string $name,
        private readonly string $description,
        private readonly string $type,
    ) {
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getType(): string
    {
        return $this->type;
    }
}

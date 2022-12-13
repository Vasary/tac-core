<?php

declare(strict_types=1);

namespace App\Shared\Transfer;

final class UpdateUnitTransfer
{
    use CreateFromTrait;

    public function __construct(
        private readonly string $id,
        private readonly string $name,
        private readonly string $alias,
        /** @param int[] $suggestions */
        private readonly array $suggestions,
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

    public function getAlias(): string
    {
        return $this->alias;
    }

    /**
     * @return int[]
     */
    public function getSuggestions(): array
    {
        return $this->suggestions;
    }
}

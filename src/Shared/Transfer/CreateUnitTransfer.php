<?php

declare(strict_types=1);

namespace App\Shared\Transfer;

final class CreateUnitTransfer
{
    use CreateFromTrait;

    public function __construct(
        private readonly string $name,
        private readonly string $alias,
        /** @param int[] $suggestions */
        private readonly array $suggestions,
    ) {
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

<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

final class Suggestions
{
    private array $suggestions;

    public function __construct()
    {
        $this->suggestions = [];
    }

    public function addSuggestions(Suggestion $suggestion): self
    {
        $this->suggestions[] = $suggestion;

        return $this;
    }

    public function getSuggestions(): array
    {
        return $this->suggestions;
    }
}

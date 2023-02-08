<?php

declare(strict_types = 1);

namespace App\Infrastructure\Assert;

use Attribute;
use Symfony\Component\Validator\Attribute\HasNamedArguments;
use Symfony\Component\Validator\Constraint;

#[Attribute]
final class UnitSuggestion extends Constraint
{
    public string $requiredMessage = 'Unit suggestion is required';
    public bool $required;

    #[HasNamedArguments]
    public function __construct(bool $mode = false, array $groups = null, mixed $payload = null)
    {
        parent::__construct([], $groups, $payload);

        $this->required = $mode;
    }

    public function validatedBy(): string
    {
        return self::class . 'Validator';
    }
}

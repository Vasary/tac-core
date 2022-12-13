<?php

declare(strict_types=1);

namespace App\Infrastructure\Assert;

use Attribute;
use Symfony\Component\Validator\Attribute\HasNamedArguments;
use Symfony\Component\Validator\Constraint;

#[Attribute]
final class NotBlank extends Constraint
{
    public string $requiredMessage = '{{ name }} is required';
    public bool $required = false;
    public string $name;

    #[HasNamedArguments]
    public function __construct(string $name, bool $mode = false, array $groups = null, mixed $payload = null)
    {
        $this->required = $mode;
        $this->name = $name;

        parent::__construct([], $groups, $payload);
    }

    public function validatedBy(): string
    {
        return self::class . 'Validator';
    }
}

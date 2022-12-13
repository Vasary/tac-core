<?php

declare(strict_types=1);

namespace App\Infrastructure\Assert;

use Attribute;
use Symfony\Component\Validator\Attribute\HasNamedArguments;
use Symfony\Component\Validator\Constraint;

#[Attribute]
final class UnitAlias extends Constraint
{
    public string $requiredMessage = 'Unit alias is required';
    public string $invalidLengthMessage = 'Unit alias should be more then 1 or less then 5 symbols';
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

<?php

declare(strict_types = 1);

namespace App\Infrastructure\Assert;

use Attribute;
use Symfony\Component\Validator\Attribute\HasNamedArguments;
use Symfony\Component\Validator\Constraint;

#[Attribute]
final class CategoryName extends Constraint
{
    public bool $required = false;

    #[HasNamedArguments]
    public function __construct(bool $mode = false, array $groups = null, mixed $payload = null)
    {
        parent::__construct([], $groups, $payload);

        $this->required = $mode;
    }

    public function validatedBy(): string
    {
        return self::class.'Validator';
    }
}

<?php

declare(strict_types = 1);

namespace App\Infrastructure\Assert;

use Attribute;
use Symfony\Component\Validator\Attribute\HasNamedArguments;
use Symfony\Component\Validator\Constraint;

#[Attribute]
final class AttributeName extends Constraint
{
    public string $requiredMessage = 'Attribute name is required';
    public string $stringLength = 'Attribute name should be mre then 3 and less then 50 symbols';
    public bool $required = false;

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

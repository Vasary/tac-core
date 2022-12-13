<?php

declare(strict_types=1);

namespace App\Infrastructure\Assert;

use Attribute;
use Symfony\Component\Validator\Attribute\HasNamedArguments;
use Symfony\Component\Validator\Constraint;

#[Attribute]
final class Units extends Constraint
{
    public string $requiredMessage = 'Units list is required';
    public string $emptyMessage = 'Units list is empty';
    public bool $required;
    public bool $validateId;

    #[HasNamedArguments]
    public function __construct(bool $mode = false, bool $validateId = false, array $groups = null, mixed $payload = null)
    {
        parent::__construct([], $groups, $payload);

        $this->required = $mode;
        $this->validateId = $validateId;
    }

    public function validatedBy(): string
    {
        return self::class . 'Validator';
    }
}

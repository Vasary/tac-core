<?php

declare(strict_types = 1);

namespace App\Infrastructure\Assert;

use Attribute;
use Symfony\Component\Validator\Attribute\HasNamedArguments;
use Symfony\Component\Validator\Constraint;

#[Attribute]
final class AttributeValue extends Constraint
{
    public string $emptyMessage = 'Attribute value is empty';
    public string $lengthLess = 'Value should be more then 3 symbols';
    public string $lengthGreatThen = 'Value should be less then 255 symbols';
    public bool $required;
    #[HasNamedArguments]
    public function __construct(bool $mode = false, public bool $validateId = true, array $groups = null, mixed $payload = null)
    {
        parent::__construct([], $groups, $payload);

        $this->required = $mode;
    }

    public function validatedBy(): string
    {
        return self::class.'Validator';
    }
}

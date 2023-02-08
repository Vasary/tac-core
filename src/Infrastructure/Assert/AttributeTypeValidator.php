<?php

declare(strict_types = 1);

namespace App\Infrastructure\Assert;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

final class AttributeTypeValidator extends ConstraintValidator
{
    private const ALLOWED_TYPES = [
        'string',
        'integer',
        'array',
        'boolean',
        'float',
    ];

    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof AttributeType) {
            throw new UnexpectedTypeException($constraint, AttributeType::class);
        }

        if (!$constraint->required && empty($value)) {
            return;
        }

        if (true === $constraint->required && empty($value)) {
            $this->context->buildViolation($constraint->requiredMessage)->addViolation();
        }

        if (!is_string($value)) {
            throw new UnexpectedValueException($value, 'string');
        }

        if (!in_array($value, self::ALLOWED_TYPES, true)) {
            $this->context->buildViolation($constraint->attributeTypeMessage)->addViolation();
        }
    }
}

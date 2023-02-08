<?php

declare(strict_types = 1);

namespace App\Infrastructure\Assert;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

final class BooleanValidator extends ConstraintValidator
{
    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof Boolean) {
            throw new UnexpectedTypeException($constraint, Boolean::class);
        }

        if (!$constraint->required && empty($value)) {
            return;
        }

        if (true === $constraint->required && null === $value) {
            $this->context->buildViolation($constraint->emptyMessage)->addViolation();
        }

        if (!is_bool($value)) {
            throw new UnexpectedValueException($value, 'boolean');
        }
    }
}

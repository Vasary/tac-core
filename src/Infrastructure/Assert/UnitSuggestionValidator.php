<?php

declare(strict_types = 1);

namespace App\Infrastructure\Assert;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

final class UnitSuggestionValidator extends ConstraintValidator
{
    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof UnitSuggestion) {
            throw new UnexpectedTypeException($constraint, UnitSuggestion::class);
        }

        if (!$constraint->required && empty($value)) {
            return;
        }

        if (true === $constraint->required && empty($value)) {
            $this->context->buildViolation($constraint->requiredMessage)->addViolation();
        }

        if (!is_int($value)) {
            throw new UnexpectedValueException($value, 'integer');
        }
    }
}

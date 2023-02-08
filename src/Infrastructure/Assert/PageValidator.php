<?php

declare(strict_types = 1);

namespace App\Infrastructure\Assert;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

final class PageValidator extends ConstraintValidator
{
    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof Page) {
            throw new UnexpectedTypeException($constraint, Page::class);
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

        if ($value <= 0) {
            $this->context->buildViolation($constraint->lessMessage)->addViolation();
        }
    }
}

<?php

declare(strict_types = 1);

namespace App\Infrastructure\Assert;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

final class AttributeDescriptionValidator extends ConstraintValidator
{
    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof AttributeDescription) {
            throw new UnexpectedTypeException($constraint, AttributeDescription::class);
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

        if (mb_strlen($value) > 255 || mb_strlen($value) < 3) {
            $this->context->buildViolation($constraint->stringLength)->addViolation();
        }
    }
}

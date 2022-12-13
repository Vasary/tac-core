<?php

declare(strict_types=1);

namespace App\Infrastructure\Assert;

use Attribute;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

#[Attribute]
final class AttributeValueValidator extends ConstraintValidator
{
    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof AttributeValue) {
            throw new UnexpectedTypeException($constraint, AttributeValue::class);
        }

        if (!$constraint->required && empty($value)) {
            return;
        }

        if (true === $constraint->required && empty($value)) {
            $this->context->buildViolation($constraint->emptyMessage)->atPath('value')->addViolation();
        }

        if (is_string($value['value'])) {
            $value = $value['value'];

            if (mb_strlen($value) < 2) {
                $this->context->buildViolation($constraint->lengthLess)->atPath('value')->addViolation();
            }

            if (mb_strlen($value) > 255) {
                $this->context->buildViolation($constraint->lengthGreatThen)->atPath('value')->addViolation();
            }
        }

        if ($constraint->validateId) {
            $this->context->getValidator()->inContext($this->context)->atPath('id')->validate($value['id'], new Id());
        }
    }
}

<?php

declare(strict_types=1);

namespace App\Infrastructure\Assert;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

final class AttributesValidator extends ConstraintValidator
{
    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof Attributes) {
            throw new UnexpectedTypeException($constraint, Attributes::class);
        }

        if (!$constraint->required && empty($value)) {
            return;
        }

        if (true === $constraint->required && empty($value)) {
            $this->context->buildViolation($constraint->requiredMessage)->addViolation();
        }

        if (!is_array($value)) {
            throw new UnexpectedValueException($value, 'array');
        }

        if (0 === count($value)) {
            $this->context->buildViolation($constraint->emptyMessage)->addViolation();

            return;
        }

        $context = $this->context;
        foreach ($value as $key => $attributeValue) {
            $this
                ->context
                ->getValidator()
                ->inContext($context)
                ->atPath('['.$key.']')
                ->validate($attributeValue, new AttributeValue(true, $constraint->validateId));
        }
    }
}

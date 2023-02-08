<?php

declare(strict_types = 1);

namespace App\Domain\Event;

use App\Domain\Model\AttributeValue;

final class AttributeValueRemoved implements EventInterface
{
    public function __construct(
        private readonly AttributeValue $attributeValue
    ) {
    }

    public function getAttributeValue(): AttributeValue
    {
        return $this->attributeValue;
    }
}

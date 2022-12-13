<?php

declare(strict_types=1);

namespace App\Domain\Event;

use App\Domain\Model\Attribute;

final class AttributeCreated implements EventInterface
{
    public function __construct(
        private readonly Attribute $attribute
    ) {
    }

    public function getAttribute(): Attribute
    {
        return $this->attribute;
    }
}

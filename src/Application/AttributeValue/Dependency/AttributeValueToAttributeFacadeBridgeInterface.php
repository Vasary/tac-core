<?php

declare(strict_types=1);

namespace App\Application\AttributeValue\Dependency;

use App\Domain\Model\Attribute;

interface AttributeValueToAttributeFacadeBridgeInterface
{
    public function getById(string $id): Attribute;
}

<?php

declare(strict_types = 1);

namespace App\Application\Product\Dependency;

use App\Domain\Model\AttributeValue;
use App\Domain\ValueObject\Id;
use App\Shared\Transfer\AttributeValueTransfer;
use Generator;

interface ProductToAttributeValueFacadeBridgeInterface
{
    public function create(AttributeValueTransfer $transfer): Generator;

    public function findByProductAndAttribute(Id $product, Id $attribute): ?AttributeValue;
}

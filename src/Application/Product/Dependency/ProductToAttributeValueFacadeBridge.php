<?php

declare(strict_types = 1);

namespace App\Application\Product\Dependency;

use App\Application\AttributeValue\Business\AttributeValueFacadeInterface;
use App\Domain\Model\AttributeValue;
use App\Domain\ValueObject\Id;
use App\Shared\Transfer\AttributeValueTransfer;
use Generator;

final class ProductToAttributeValueFacadeBridge implements ProductToAttributeValueFacadeBridgeInterface
{
    public function __construct(private readonly AttributeValueFacadeInterface $facade) {
    }

    public function create(AttributeValueTransfer $transfer): Generator
    {
        return $this->facade->create($transfer);
    }

    public function findByProductAndAttribute(Id $product, Id $attribute): ?AttributeValue
    {
        return $this->facade->findByProductAndAttribute($product, $attribute);
    }
}

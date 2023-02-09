<?php

declare(strict_types = 1);

namespace App\Application\AttributeValue\Business;

use App\Application\AttributeValue\Business\Creator\AttributeValueCreatorInterface;
use App\Application\AttributeValue\Business\Finder\FinderInterface;
use App\Domain\Model\AttributeValue;
use App\Domain\ValueObject\Id;
use App\Shared\Transfer\AttributeValueTransfer;
use Generator;

final class AttributeValueFacade implements AttributeValueFacadeInterface
{
    public function __construct(
        private readonly AttributeValueCreatorInterface $attributeCreator,
        private readonly FinderInterface $finder,
    ) {
    }

    public function create(AttributeValueTransfer $transfer): Generator
    {
        return $this->attributeCreator->create($transfer);
    }

    public function list(int $page, int $pageSize): Generator
    {
        return $this->finder->list($page, $pageSize);
    }

    public function findByProductAndAttribute(Id $productId, Id $attributeId): ?AttributeValue
    {
        return $this->finder->findByProductIdAndAttributeId($productId, $attributeId);
    }

    public function getTotal(): int
    {
        return $this->finder->getTotal();
    }
}

<?php

declare(strict_types = 1);

namespace App\Application\AttributeValue\Business\Creator;

use App\Application\AttributeValue\Business\Creator\TypeCreator\TypeResolver;
use App\Application\AttributeValue\Dependency\AttributeValueToAttributeFacadeBridgeInterface;
use App\Domain\Model\Attribute;
use App\Domain\Model\AttributeValue;
use App\Domain\ValueObject\Id;
use App\Infrastructure\Security\Security;
use App\Shared\Transfer\AttributeValueTransfer;
use Generator;

final class AttributeValueCreator implements AttributeValueCreatorInterface
{
    public function __construct(
        private readonly TypeResolver $typeResolver,
        private readonly Security $security,
        private readonly AttributeValueToAttributeFacadeBridgeInterface $attributeFacadeBridge,
    ) {
    }

    public function create(AttributeValueTransfer $transfer): Generator
    {
        $attribute = $this->attributeFacadeBridge->getById($transfer->getId());

        $parentId = null;
        if (null !== $transfer->getParent()) {
            $parentAttribute = $this->attributeFacadeBridge->getById($transfer->getParent());
            $parentId = $parentAttribute->getId();
        }

        yield $this->createAttribute($attribute, $transfer, $parentId);
    }

    private function createAttribute(
        Attribute $attribute,
        AttributeValueTransfer $transfer,
        ?Id $parent
    ): AttributeValue {
        return $this
            ->typeResolver
            ->resolve((string) $attribute->getType())
            ->create($transfer, $attribute, $this->security->getDomainUser(), $parent);
    }
}

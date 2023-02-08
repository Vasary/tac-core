<?php

declare(strict_types = 1);

namespace App\Application\Product\Business\Updater\Component;

use App\Application\Product\Dependency\ProductToAttributeValueFacadeBridgeInterface;
use App\Application\Product\Helper\ArrayTransformer;
use App\Domain\Model\Attribute;
use App\Domain\Model\AttributeValue;
use App\Domain\Model\AttributeValue\Value;
use App\Domain\Model\Product;
use App\Domain\ValueObject\Id;
use App\Shared\Transfer\AttributeValueTransfer;
use App\Shared\Transfer\UpdateProductTransfer;
use Doctrine\ORM\EntityManagerInterface;

final class AttributeUpdater
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly ProductToAttributeValueFacadeBridgeInterface $attributeFacadeBridge,
    ) {
    }

    public function updateAttributes(Product $product, UpdateProductTransfer $transfer): void
    {
        $transferAttributes = ArrayTransformer::transform($transfer->getAttributes());

        $toRemove = $this->remove($product, $transferAttributes);
        $toSave = $this->save($product, $transferAttributes);
        $toUpdate = $this->update($product, $transferAttributes);

        foreach ($toRemove as $item) {
            /** @var AttributeValue $item */

            $product->removeAttribute($item);
            $this->entityManager->remove($item);
        }

        foreach ($toSave as $item) {
            /** @var AttributeValue $item */
            $product->addAttribute($item);
        }

        $valueUpdater = function (AttributeValue $value) use ($transfer, $product): void {
            $result = array_filter(
                ArrayTransformer::transform($transfer->getAttributes()),
                fn(AttributeValueTransfer $v) => $value->getAttribute()->getId()->equalTo(Id::fromString($v->getId()))
            );

            /** @var AttributeValueTransfer $resultItem */
            $resultItem = current($result);

            if ($this->isValueChanged($value, $resultItem)) {
                $valueObject = new Value(
                    null === $resultItem->getValue()
                        ? null
                        : (string)$resultItem->getValue()
                );

                $value->setValue($valueObject);
            }

            if ($this->isParentHasBeenChanged($value, $resultItem, $product->getId())) {
                $parentValue = null !== $resultItem->getParent()
                    ? Id::fromString($resultItem->getParent())
                    : null;

                $value->setParent($parentValue);
            }
        };

        foreach ($toUpdate as $item) {
            /** @var AttributeValue $item */
            $valueUpdater($item);
        }
    }

    private function save(Product $product, array $transferAttributes): array
    {
        $toSave = array_udiff(
            $transferAttributes,
            array_map(
                fn(AttributeValue $attributeValue) => $attributeValue->getAttribute(),
                $product->getAttributes()->toArray()
            ),
            fn($a, $b) => strcmp((string)$a->getId(), (string)$b->getId())
        );

        $result = [];
        foreach ($toSave as $toSaveItem) {
            /** @var AttributeValueTransfer $toSaveItem */
            $result = array_merge($result, iterator_to_array($this->attributeFacadeBridge->create($toSaveItem)));
        }

        return $result;
    }

    private function remove(Product $product, array $transferAttributes): array
    {
        $attributesIds = array_map(
            fn(AttributeValue $attributeValue) => $attributeValue->getAttribute(),
            $product->getAttributes()->toArray()
        );

        $diff = array_udiff(
            $attributesIds,
            $transferAttributes,
            fn($a, $b) => strcmp((string)$a->getId(), (string)$b->getId())
        );

        $filtered = $product->getAttributes()->filter(
            fn(AttributeValue $attributeValue) => in_array(
                (string)$attributeValue->getAttribute()->getId(),
                array_map(
                    fn(Attribute $attribute) => (string)$attribute->getId(),
                    $diff
                )
            )
        );

        return $filtered->toArray();
    }

    private function update(Product $product, array $transferAttributes): array
    {
        $collection = $product->getAttributes()->filter(
            fn(AttributeValue $value) => $this->shouldUpdate(
                $value,
                $this->extractAttributeValueTransfer($value->getAttribute(), $transferAttributes),
                $product->getId(),
            )
        );

        return $collection->toArray();
    }

    private function extractAttributeValueTransfer(Attribute $attribute, array $attributes): ?AttributeValueTransfer
    {
        $result = array_filter(
            $attributes,
            fn(AttributeValueTransfer $transferValue) => (string)$attribute->getId() === $transferValue->getId()
        );

        if (1 === count($result)) {
            return current($result);
        }

        return null;
    }

    private function shouldUpdate(AttributeValue $value, ?AttributeValueTransfer $transfer, Id $productId): bool
    {
        if (null === $transfer) {
            return false;
        }

        $isAttribute = (string)$value->getAttribute()->getId() === $transfer->getId();
        $isParentHasBeenAdded = $this->isParentHasBeenChanged($value, $transfer, $productId);

        return $isAttribute && ($this->isValueChanged($value, $transfer) || $isParentHasBeenAdded);
    }

    private function isParentHasBeenChanged(AttributeValue $value, ?AttributeValueTransfer $transfer, Id $productId): bool
    {
        if (null !== $value->getParent()) {
            $parentId = $this
                ->attributeFacadeBridge
                ->findByProductAndAttribute($productId, $value->getParent())
                ?->getAttribute()
                ?->getId();

            return (string)$parentId !== (string)$transfer->getParent();
        }

        return null !== $transfer->getParent();
    }

    private function isValueChanged(AttributeValue $value, AttributeValueTransfer $transfer): bool
    {
        return $value->getValue()->getValue() !== $transfer->getValue();
    }
}

<?php

declare(strict_types = 1);

namespace App\Application\Product\Business\Creator;

use App\Application\Product\Dependency\ProductToAttributeValueFacadeBridgeInterface;
use App\Application\Product\Dependency\ProductToCategoryFacadeBridgeInterface;
use App\Application\Product\Dependency\ProductToUnitFacadeBridgeInterface;
use App\Application\Product\Helper\ArrayTransformer;
use App\Domain\Model\AttributeValue;
use App\Domain\Model\Product;
use App\Domain\Model\Unit;
use App\Domain\Repository\ProductRepositoryInterface;
use App\Domain\ValueObject\I18N;
use App\Infrastructure\Security\Security;
use App\Shared\Transfer\AttributeValueTransfer;
use App\Shared\Transfer\CreateProductTransfer;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;

final class Creator implements CreatorInterface
{
    public function __construct(
        private readonly Security $security,
        private readonly ProductRepositoryInterface $productRepository,
        private readonly ProductToAttributeValueFacadeBridgeInterface $attributeFacadeBridge,
        private readonly ProductToCategoryFacadeBridgeInterface $categoryFacadeBridge,
        private readonly ProductToUnitFacadeBridgeInterface $unitFacadeBridge,
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    public function create(CreateProductTransfer $transfer): Product
    {
        $category = $this->categoryFacadeBridge->getById($transfer->getCategory());

        $product = $this->productRepository->create(
            new I18N($transfer->getName()),
            new I18N($transfer->getDescription()),
            $this->security->getDomainUser(),
            $category
        );

        $attributesList = null === $transfer->getAttributes()
            ? []
            : ArrayTransformer::transform($transfer->getAttributes())
        ;

        $attributes = $this->createAttributes($attributesList);
        $units = $this->getUnits($transfer->getUnits());

        if (count($attributes) > 0) {
            $productAttributes = new ArrayCollection();

            foreach ($attributes as $item) {
                foreach ($item as $attributeObject) {
                    /** @var AttributeValue $attributeObject */
                    $attributeObject->setProduct($product);
                    $productAttributes->add($attributeObject);
                }
            }

            $product->setAttributes($productAttributes);
        }

        if (count($units) > 0) {
            $productUnits = new ArrayCollection();

            foreach ($units as $unit) {
                /** @var Unit $unit */
                $productUnits->add($unit);
            }

            $product->setUnits($productUnits);
        }

        $this->entityManager->persist($product);

        return $product;
    }

    private function getUnits(?array $units): array
    {
        if (null === $units) {
            return [];
        }

        return array_map(
            fn (string $id) => $this->unitFacadeBridge->getById($id),
            $units
        );
    }

    private function createAttributes(array $attributes): array
    {
        return array_map(
            fn (AttributeValueTransfer $transfer) => $this->attributeFacadeBridge->create($transfer),
            $attributes,
        );
    }
}

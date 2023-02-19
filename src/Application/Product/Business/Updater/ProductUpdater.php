<?php

declare(strict_types = 1);

namespace App\Application\Product\Business\Updater;

use App\Application\Product\Business\Updater\Component\AttributeUpdater;
use App\Application\Product\Business\Updater\Component\UnitsUpdater;
use App\Domain\Model\Product;
use App\Domain\Repository\ProductRepositoryInterface;
use App\Domain\ValueObject\I18N;
use App\Domain\ValueObject\Id;
use App\Shared\Exception\ProductNotFound;
use App\Shared\Transfer\DeleteProductTransfer;
use App\Shared\Transfer\UpdateProductTransfer;
use Doctrine\ORM\EntityManagerInterface;

final class ProductUpdater implements ProductUpdaterInterface
{
    public function __construct(
        private readonly ProductRepositoryInterface $repository,
        private readonly AttributeUpdater $attributeUpdater,
        private readonly UnitsUpdater $unitsUpdater,
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    public function update(UpdateProductTransfer $transfer): Product
    {
        if (null === $product = $this->repository->findById(Id::fromString($transfer->getId()))) {
            throw new ProductNotFound();
        }

        if ($product->getName()->value() !== $transfer->getName()) {
            $product->setName(new I18N($transfer->getName()));
        }

        if ($product->getDescription()->value() !== $transfer->getDescription()) {
            $product->setDescription(new I18N($transfer->getDescription()));
        }

        $this->attributeUpdater->updateAttributes($product, $transfer);
        $this->unitsUpdater->updateUnits($product, $transfer);

        $this->entityManager->persist($product);

        return $product;
    }

    public function delete(DeleteProductTransfer $transfer): void
    {
        if (null === $product = $this->repository->findById(Id::fromString($transfer->getId()))) {
            throw new ProductNotFound();
        }

        $this->repository->delete($product);
    }
}

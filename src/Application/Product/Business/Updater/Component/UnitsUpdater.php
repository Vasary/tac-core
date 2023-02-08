<?php

declare(strict_types = 1);

namespace App\Application\Product\Business\Updater\Component;

use App\Application\Product\Dependency\ProductToUnitFacadeBridgeInterface;
use App\Domain\Model\Product;
use App\Domain\Model\Unit;
use App\Shared\Transfer\UpdateProductTransfer;

final class UnitsUpdater
{
    public function __construct(
        private readonly ProductToUnitFacadeBridgeInterface $unitFacadeBridge,
    ) {
    }

    public function updateUnits(Product $product, UpdateProductTransfer $transfer): void
    {
        $currentUnits = array_map(
            fn (Unit $unit) => (string) $unit->getId(),
            $product->getUnits()->toArray()
        );

        $requestedUnits = $transfer->getUnits();

        $save = array_diff($requestedUnits, $currentUnits);
        $remove = array_diff($currentUnits, $requestedUnits);

        $toRemove = $product->getUnits()->filter(fn (Unit $unit) => in_array((string)$unit->getId(), $remove));
        foreach ($toRemove as $removeUnit) {
            $product->removeUnit($removeUnit);
        }

        foreach ($save as $saveId) {
            $product->addUnit($this->unitFacadeBridge->getById($saveId));
        }
    }
}

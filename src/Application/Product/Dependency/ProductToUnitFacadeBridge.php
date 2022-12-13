<?php

declare(strict_types=1);

namespace App\Application\Product\Dependency;

use App\Application\Unit\Business\UnitFacadeInterface;
use App\Domain\Model\Unit;
use App\Shared\Transfer\GetUnitTransfer;

final class ProductToUnitFacadeBridge implements ProductToUnitFacadeBridgeInterface
{
    public function __construct(
        private readonly UnitFacadeInterface $unitFacade
    ) {
    }

    public function getById(string $id): Unit
    {
        return $this->unitFacade->getUnit(new GetUnitTransfer($id));
    }
}

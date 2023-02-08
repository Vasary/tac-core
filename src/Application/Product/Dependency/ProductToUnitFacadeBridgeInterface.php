<?php

declare(strict_types = 1);

namespace App\Application\Product\Dependency;

use App\Domain\Model\Unit;

interface ProductToUnitFacadeBridgeInterface
{
    public function getById(string $id): Unit;
}

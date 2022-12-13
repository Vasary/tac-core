<?php

declare(strict_types=1);

namespace App\Application\Product\Dependency;

use App\Domain\Model\Category;

interface ProductToCategoryFacadeBridgeInterface
{
    public function getById(string $id): Category;
}

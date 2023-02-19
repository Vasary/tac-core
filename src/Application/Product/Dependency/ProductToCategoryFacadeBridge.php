<?php

declare(strict_types = 1);

namespace App\Application\Product\Dependency;

use App\Application\Category\Business\CategoryFacadeInterface;
use App\Domain\Model\Category;
use App\Shared\Transfer\GetCategoryTransfer;

final class ProductToCategoryFacadeBridge implements ProductToCategoryFacadeBridgeInterface
{
    public function __construct(private readonly CategoryFacadeInterface $categoryFacade) {
    }

    public function getById(string $id): Category
    {
        return $this->categoryFacade->getById(GetCategoryTransfer::fromArray(['id' => $id]));
    }
}

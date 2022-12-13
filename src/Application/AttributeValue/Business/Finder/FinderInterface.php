<?php

declare(strict_types=1);

namespace App\Application\AttributeValue\Business\Finder;

use App\Domain\Model\AttributeValue;
use App\Domain\ValueObject\Id;
use Generator;

interface FinderInterface
{
    public function list(int $page, int $pageSize): Generator;

    public function findByProductIdAndAttributeId(Id $productId, Id $attributeId): ?AttributeValue;
}

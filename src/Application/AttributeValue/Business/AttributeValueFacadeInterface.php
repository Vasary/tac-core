<?php

declare(strict_types=1);

namespace App\Application\AttributeValue\Business;

use App\Domain\Model\AttributeValue;
use App\Domain\ValueObject\Id;
use App\Shared\Transfer\AttributeValueTransfer;
use Generator;

interface AttributeValueFacadeInterface
{
    public function create(AttributeValueTransfer $transfer): Generator;

    public function list(int $page, int $pageSize): Generator;

    public function findByProductAndAttribute(Id $productId, Id $attributeId): ?AttributeValue;
}

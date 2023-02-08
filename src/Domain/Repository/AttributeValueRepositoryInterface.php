<?php

declare(strict_types = 1);

namespace App\Domain\Repository;

use App\Domain\Model\Attribute;
use App\Domain\Model\AttributeValue;
use App\Domain\Model\User;
use App\Domain\ValueObject\Id;
use Generator;

interface AttributeValueRepositoryInterface
{
    public function findAll(int $page, int $pageSize): Generator;

    public function create(
        ?Attribute $attribute,
        string     $type,
        ?string    $value,
        User       $creator,
        ?Id        $parentId
    ): AttributeValue;

    public function get(Id $id): ?AttributeValue;

    public function findByProductIdAndAttributeId(Id $productId, Id $attributeId): ?AttributeValue;
}

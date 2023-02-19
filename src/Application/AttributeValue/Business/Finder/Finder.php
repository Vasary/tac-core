<?php

declare(strict_types = 1);

namespace App\Application\AttributeValue\Business\Finder;

use App\Domain\Model\AttributeValue;
use App\Domain\Repository\AttributeValueRepositoryInterface;
use App\Domain\ValueObject\Id;
use Generator;

final class Finder implements FinderInterface
{
    public function __construct(private readonly AttributeValueRepositoryInterface $repository,) {
    }

    public function list(int $page, int $pageSize): Generator
    {
        return $this->repository->findAll($page, $pageSize);
    }

    public function findByProductIdAndAttributeId(Id $productId, Id $attributeId): ?AttributeValue
    {
        return $this->repository->findByProductIdAndAttributeId($productId, $attributeId);
    }

    public function getTotal(): int
    {
        return $this->repository->getTotal();
    }
}

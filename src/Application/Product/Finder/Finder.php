<?php

declare(strict_types=1);

namespace App\Application\Product\Finder;

use App\Domain\Model\Product;
use App\Domain\Repository\ProductRepositoryInterface;
use App\Domain\ValueObject\Id;
use App\Shared\Exception\ProductNotFound;
use Generator;

final class Finder implements FinderInterface
{
    public function __construct(
        private readonly ProductRepositoryInterface $productRepository,
    ) {
    }

    public function getList(int $page, int $size): Generator
    {
        return $this->productRepository->list($page, $size);
    }

    public function getById(string $id): Product
    {
        if (null === $product = $this->productRepository->findById(Id::fromString($id))) {
            throw new ProductNotFound();
        }

        return $product;
    }

    public function getTotalCount(): int
    {
        return $this->productRepository->totalCount();
    }
}

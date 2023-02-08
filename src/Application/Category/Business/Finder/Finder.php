<?php

declare(strict_types = 1);

namespace App\Application\Category\Business\Finder;

use App\Domain\Model\Category;
use App\Domain\Repository\CategoryRepositoryInterface;
use App\Domain\ValueObject\Id;
use App\Shared\Exception\CategoryNotFound;
use Generator;

final class Finder implements FinderInterface
{
    public function __construct(
        private readonly CategoryRepositoryInterface $repository,
    ) {
    }

    public function getList(int $page, int $size): Generator
    {
        return $this->repository->list($page, $size);
    }

    public function getTotalCount(): int
    {
        return $this->repository->totalCount();
    }

    public function getById(string $id): Category
    {
        if (null === $category = $this->repository->findById(Id::fromString($id))) {
            throw new CategoryNotFound();
        }

        return $category;
    }
}

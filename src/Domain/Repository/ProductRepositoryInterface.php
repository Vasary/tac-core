<?php

declare(strict_types = 1);

namespace App\Domain\Repository;

use App\Domain\Model\Category;
use App\Domain\Model\Product;
use App\Domain\Model\User;
use App\Domain\ValueObject\I18N;
use App\Domain\ValueObject\Id;
use Generator;

interface ProductRepositoryInterface
{
    public function findById(Id $id): ?Product;

    public function create(I18N $name, I18N $description, User $creator, Category $category,): Product;

    public function list(int $page, int $size): Generator;

    public function totalCount(): int;
}

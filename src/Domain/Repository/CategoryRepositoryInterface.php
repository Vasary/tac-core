<?php

declare(strict_types = 1);

namespace App\Domain\Repository;

use App\Domain\Model\Category;
use App\Domain\Model\User;
use App\Domain\ValueObject\I18N;
use App\Domain\ValueObject\Id;
use Generator;

interface CategoryRepositoryInterface
{
    public function create(I18N $name, User $user): Category;

    public function list(int $page, int $size): Generator;

    public function findById(Id $id): ?Category;

    public function totalCount(): int;

    public function delete(Category $category): void;
}

<?php

declare(strict_types = 1);

namespace App\Domain\Repository;

use App\Domain\Model\Unit;
use App\Domain\Model\User;
use App\Domain\ValueObject\I18N;
use App\Domain\ValueObject\Id;
use App\Domain\ValueObject\Suggestions;
use Generator;

interface UnitRepositoryInterface
{
    public function create(I18N $name, I18N $alias, Suggestions $suggestions, User $user): Unit;

    public function list(int $page, int $size): Generator;

    public function findById(Id $id): ?Unit;

    public function totalCount(): int;

    public function delete(Unit $category): void;
}

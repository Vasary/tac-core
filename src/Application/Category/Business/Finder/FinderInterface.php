<?php

declare(strict_types=1);

namespace App\Application\Category\Business\Finder;

use App\Domain\Model\Category;
use Generator;

interface FinderInterface
{
    public function getById(string $id): Category;

    public function getList(int $page, int $size): Generator;

    public function getTotalCount(): int;
}

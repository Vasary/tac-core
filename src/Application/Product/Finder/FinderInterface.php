<?php

declare(strict_types = 1);

namespace App\Application\Product\Finder;

use App\Domain\Model\Product;
use Generator;

interface FinderInterface
{
    public function getList(int $page, int $size): Generator;

    public function getById(string $id): Product;

    public function getTotalCount(): int;
}

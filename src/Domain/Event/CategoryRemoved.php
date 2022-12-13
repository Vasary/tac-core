<?php

declare(strict_types=1);

namespace App\Domain\Event;

use App\Domain\Model\Category;

final class CategoryRemoved implements EventInterface
{
    public function __construct(
        private readonly Category $category
    ) {
    }

    public function getCategory(): Category
    {
        return $this->category;
    }
}

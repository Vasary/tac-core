<?php

declare(strict_types=1);

namespace App\Domain\Event;

use App\Domain\Model\Product;

final class ProductUpdated implements EventInterface
{
    public function __construct(
        private readonly Product $product
    ) {
    }

    public function getProduct(): Product
    {
        return $this->product;
    }
}

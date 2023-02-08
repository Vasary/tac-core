<?php

declare(strict_types = 1);

namespace App\Application\Product\Business\Creator;

use App\Domain\Model\Product;
use App\Shared\Transfer\CreateProductTransfer;

interface CreatorInterface
{
    public function create(CreateProductTransfer $transfer): Product;
}

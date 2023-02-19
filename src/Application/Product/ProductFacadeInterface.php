<?php

declare(strict_types = 1);

namespace App\Application\Product;

use App\Domain\Model\Product;
use App\Shared\Transfer\CreateProductTransfer;
use App\Shared\Transfer\DeleteProductTransfer;
use App\Shared\Transfer\GetProductTransfer;
use App\Shared\Transfer\UpdateProductTransfer;
use Generator;

interface ProductFacadeInterface
{
    public function findById(GetProductTransfer $transfer): ?Product;

    public function create(CreateProductTransfer $transfer): Product;

    public function getList(int $page, int $size): Generator;

    public function update(UpdateProductTransfer $transfer): Product;

    public function getTotalCount(): int;

    public function delete(DeleteProductTransfer $transfer): void;
}

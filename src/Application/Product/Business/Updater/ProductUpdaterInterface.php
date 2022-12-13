<?php

declare(strict_types=1);

namespace App\Application\Product\Business\Updater;

use App\Domain\Model\Product;
use App\Shared\Transfer\UpdateProductTransfer;

interface ProductUpdaterInterface
{
    public function update(UpdateProductTransfer $transfer): Product;
}

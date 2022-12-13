<?php

declare(strict_types=1);

namespace App\Application\Category\Business\Updater;

use App\Domain\Model\Category;
use App\Shared\Transfer\UpdateCategoryTransfer;

interface UpdaterInterface
{
    public function delete(string $id): void;

    public function update(UpdateCategoryTransfer $transfer): Category;
}

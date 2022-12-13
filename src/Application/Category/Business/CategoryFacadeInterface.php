<?php

declare(strict_types=1);

namespace App\Application\Category\Business;

use App\Domain\Model\Category;
use App\Shared\Transfer\CategoryCreateTransfer;
use App\Shared\Transfer\DeleteCategoryTransfer;
use App\Shared\Transfer\GetCategoryTransfer;
use App\Shared\Transfer\UpdateCategoryTransfer;
use Generator;

interface CategoryFacadeInterface
{
    public function create(CategoryCreateTransfer $transfer): Category;

    public function update(UpdateCategoryTransfer $transfer): Category;

    public function getList(int $page, int $size): Generator;

    public function getTotalCount(): int;

    public function getById(GetCategoryTransfer $transfer): Category;

    public function delete(DeleteCategoryTransfer $transfer): void;
}

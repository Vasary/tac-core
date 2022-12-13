<?php

declare(strict_types=1);

namespace App\Application\Category\Business;

use App\Application\Category\Business\Creator\CreatorInterface;
use App\Application\Category\Business\Finder\FinderInterface;
use App\Application\Category\Business\Updater\UpdaterInterface;
use App\Domain\Model\Category;
use App\Shared\Transfer\CategoryCreateTransfer;
use App\Shared\Transfer\DeleteCategoryTransfer;
use App\Shared\Transfer\GetCategoryTransfer;
use App\Shared\Transfer\UpdateCategoryTransfer;
use Generator;

final class CategoryFacade implements CategoryFacadeInterface
{
    public function __construct(
        private readonly CreatorInterface              $creator,
        private readonly FinderInterface               $finder,
        private readonly UpdaterInterface              $updater,
    ) {
    }

    public function create(CategoryCreateTransfer $transfer): Category
    {
        return $this->creator->create($transfer);
    }

    public function getList(int $page, int $size): Generator
    {
        return $this->finder->getList($page, $size);
    }

    public function getTotalCount(): int
    {
        return $this->finder->getTotalCount();
    }

    public function getById(GetCategoryTransfer $transfer): Category
    {
        return $this->finder->getById($transfer->getId());
    }

    public function delete(DeleteCategoryTransfer $transfer): void
    {
        $this->updater->delete($transfer->getId());
    }

    public function update(UpdateCategoryTransfer $transfer): Category
    {
        return $this->updater->update($transfer);
    }
}

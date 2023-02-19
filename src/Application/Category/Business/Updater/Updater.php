<?php

declare(strict_types = 1);

namespace App\Application\Category\Business\Updater;

use App\Domain\Model\Category;
use App\Domain\Repository\CategoryRepositoryInterface;
use App\Domain\ValueObject\I18N;
use App\Domain\ValueObject\Id;
use App\Shared\Exception\CategoryNotFound;
use App\Shared\Transfer\UpdateCategoryTransfer;

final class Updater implements UpdaterInterface
{
    public function __construct(private readonly CategoryRepositoryInterface $repository,) {
    }

    public function delete(string $id): void
    {
        $category = $this->repository->findById(Id::fromString($id));
        if (null === $category) {
            throw new CategoryNotFound();
        }

        $this->repository->delete($category);
    }

    public function update(UpdateCategoryTransfer $transfer): Category
    {
        $category = $this->repository->findById(Id::fromString($transfer->getId()));
        if (null === $category) {
            throw new CategoryNotFound();
        }

        $category->setName(new I18N($transfer->getName()));

        return $category;
    }
}

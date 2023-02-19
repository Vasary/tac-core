<?php

declare(strict_types = 1);

namespace App\Application\Product;

use App\Application\Product\Business\Creator\CreatorInterface;
use App\Application\Product\Business\Updater\ProductUpdaterInterface;
use App\Application\Product\Finder\FinderInterface;
use App\Application\Shared\Service\Transactional\TransactionalServiceInterface;
use App\Domain\Model\Product;
use App\Shared\Transfer\CreateProductTransfer;
use App\Shared\Transfer\DeleteProductTransfer;
use App\Shared\Transfer\GetProductTransfer;
use App\Shared\Transfer\UpdateProductTransfer;
use Doctrine\ORM\EntityManagerInterface;
use Generator;

final class ProductFacade implements ProductFacadeInterface
{
    public function __construct(
        private readonly CreatorInterface $creator,
        private readonly ProductUpdaterInterface $updater,
        private readonly FinderInterface $finder,
    ) {
    }

    public function create(CreateProductTransfer $transfer): Product
    {
        return $this->creator->create($transfer);
    }

    public function update(UpdateProductTransfer $transfer): Product
    {
        return $this->updater->update($transfer);
    }

    public function getList(int $page, int $size): Generator
    {
        return $this->finder->getList($page, $size);
    }

    public function findById(GetProductTransfer $transfer): ?Product
    {
        return $this->finder->getById($transfer->getId());
    }

    public function getTotalCount(): int
    {
        return $this->finder->getTotalCount();
    }

    public function delete(DeleteProductTransfer $transfer): void
    {
        $this->updater->delete($transfer);
    }
}

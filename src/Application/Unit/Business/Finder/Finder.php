<?php

declare(strict_types=1);

namespace App\Application\Unit\Business\Finder;

use App\Domain\Model\Unit;
use App\Domain\Repository\UnitRepositoryInterface;
use App\Domain\ValueObject\Id;
use App\Shared\Exception\UnitNotFound;
use App\Shared\Transfer\GetUnitTransfer;
use Generator;

final class Finder implements FinderInterface
{
    public function __construct(
        private readonly UnitRepositoryInterface $repository,
    ) {
    }

    public function getList(int $page, int $size): Generator
    {
        return $this->repository->list($page, $size);
    }

    public function getTotalCount(): int
    {
        return $this->repository->totalCount();
    }

    public function getUnit(GetUnitTransfer $transfer): Unit
    {
        if (null === $unit = $this->repository->findById(Id::fromString($transfer->getId()))) {
            throw new UnitNotFound();
        }

        return $unit;
    }
}

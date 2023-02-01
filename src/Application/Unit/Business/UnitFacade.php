<?php

declare(strict_types=1);

namespace App\Application\Unit\Business;

use App\Application\Unit\Business\Creator\CreatorInterface;
use App\Application\Unit\Business\Finder\FinderInterface;
use App\Application\Unit\Business\Updater\UpdaterInterface;
use App\Domain\Model\Unit;
use App\Shared\Transfer\CreateUnitTransfer;
use App\Shared\Transfer\DeleteUnitTransfer;
use App\Shared\Transfer\GetUnitTransfer;
use App\Shared\Transfer\UpdateUnitTransfer;
use Generator;

final class UnitFacade implements UnitFacadeInterface
{
    public function __construct(
        private readonly CreatorInterface              $creator,
        private readonly FinderInterface               $finder,
        private readonly UpdaterInterface              $updater,
    ) {
    }

    public function create(CreateUnitTransfer $transfer): Unit
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

    public function delete(DeleteUnitTransfer $transfer): void
    {
        $this->updater->delete($transfer);
    }

    public function getUnit(GetUnitTransfer $transfer): Unit
    {
        return $this->finder->getUnit($transfer);
    }

    public function update(UpdateUnitTransfer $transfer): Unit
    {
        return $this->updater->update($transfer);
    }
}

<?php

declare(strict_types = 1);

namespace App\Application\Unit\Business;

use App\Domain\Model\Unit;
use App\Shared\Transfer\CreateUnitTransfer;
use App\Shared\Transfer\DeleteUnitTransfer;
use App\Shared\Transfer\GetUnitTransfer;
use App\Shared\Transfer\UpdateUnitTransfer;
use Generator;

interface UnitFacadeInterface
{
    public function create(CreateUnitTransfer $transfer): Unit;

    public function getList(int $page, int $size): Generator;

    public function getTotalCount(): int;

    public function delete(DeleteUnitTransfer $transfer): void;

    public function getUnit(GetUnitTransfer $transfer): Unit;

    public function update(UpdateUnitTransfer $transfer): Unit;
}

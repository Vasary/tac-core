<?php

declare(strict_types = 1);

namespace App\Application\Unit\Business\Updater;

use App\Domain\Model\Unit;
use App\Shared\Transfer\DeleteUnitTransfer;
use App\Shared\Transfer\UpdateUnitTransfer;

interface UpdaterInterface
{
    public function delete(DeleteUnitTransfer $transfer): void;

    public function update(UpdateUnitTransfer $transfer): Unit;
}

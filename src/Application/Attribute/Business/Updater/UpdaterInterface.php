<?php

declare(strict_types=1);

namespace App\Application\Attribute\Business\Updater;

use App\Domain\Model\Attribute;
use App\Shared\Transfer\DeleteAttributeTransfer;
use App\Shared\Transfer\UpdateAttributeTransfer;

interface UpdaterInterface
{
    public function update(UpdateAttributeTransfer $transfer): Attribute;

    public function delete(DeleteAttributeTransfer $transfer): void;
}

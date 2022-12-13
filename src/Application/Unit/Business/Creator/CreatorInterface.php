<?php

declare(strict_types=1);

namespace App\Application\Unit\Business\Creator;

use App\Domain\Model\Unit;
use App\Shared\Transfer\CreateUnitTransfer;

interface CreatorInterface
{
    public function create(CreateUnitTransfer $transfer): Unit;
}

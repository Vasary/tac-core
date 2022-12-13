<?php

declare(strict_types=1);

namespace App\Application\Unit\Business\Finder;

use App\Shared\Transfer\GetUnitTransfer;
use Generator;

interface FinderInterface
{
    public function getList(int $page, int $size): Generator;

    public function getTotalCount(): int;

    public function getUnit(GetUnitTransfer $transfer);
}

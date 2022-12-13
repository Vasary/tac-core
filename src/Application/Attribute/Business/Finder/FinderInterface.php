<?php

declare(strict_types=1);

namespace App\Application\Attribute\Business\Finder;

use App\Domain\Model\Attribute;
use App\Shared\Transfer\GetAttributeTransfer;
use Generator;

interface FinderInterface
{
    public function getById(GetAttributeTransfer $transfer): ?Attribute;

    public function getList(int $page, int $size): Generator;

    public function getTotalCount(): int;
}

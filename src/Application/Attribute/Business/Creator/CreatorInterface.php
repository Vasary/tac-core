<?php

declare(strict_types = 1);

namespace App\Application\Attribute\Business\Creator;

use App\Domain\Model\Attribute;
use App\Shared\Transfer\AttributeCreateTransfer;

interface CreatorInterface
{
    public function create(AttributeCreateTransfer $transfer): Attribute;
}

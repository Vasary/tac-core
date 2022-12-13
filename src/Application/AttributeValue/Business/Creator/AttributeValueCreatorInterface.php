<?php

declare(strict_types=1);

namespace App\Application\AttributeValue\Business\Creator;

use App\Shared\Transfer\AttributeValueTransfer;
use Generator;

interface AttributeValueCreatorInterface
{
    public function create(AttributeValueTransfer $transfer): Generator;
}

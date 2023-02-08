<?php

declare(strict_types = 1);

namespace App\Application\AttributeValue\Business\Creator\TypeCreator;

use App\Domain\Model\Attribute;
use App\Domain\Model\AttributeValue;
use App\Domain\Model\User;
use App\Domain\ValueObject\Id;
use App\Shared\Transfer\AttributeValueTransfer;

interface AttributeCreatorInterface
{
    public function create(
        AttributeValueTransfer $transfer,
        Attribute $attribute,
        User $creator,
        ?Id $parentId = null,
    ): AttributeValue;
}

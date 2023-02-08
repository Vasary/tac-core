<?php

declare(strict_types = 1);

namespace App\Application\AttributeValue\Dependency;

use App\Application\Attribute\Business\AttributeFacadeInterface;
use App\Domain\Model\Attribute;
use App\Shared\Transfer\GetAttributeTransfer;

final class AttributeValueToAttributeFacadeBridge implements AttributeValueToAttributeFacadeBridgeInterface
{
    public function __construct(private readonly AttributeFacadeInterface $facade)
    {
    }

    public function getById(string $id): Attribute
    {
        return $this->facade->getById(new GetAttributeTransfer($id));
    }
}

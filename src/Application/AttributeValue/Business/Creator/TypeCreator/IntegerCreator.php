<?php

declare(strict_types = 1);

namespace App\Application\AttributeValue\Business\Creator\TypeCreator;

use App\Domain\Model\Attribute;
use App\Domain\Model\AttributeValue;
use App\Domain\Model\User;
use App\Domain\Repository\AttributeValueRepositoryInterface;
use App\Domain\ValueObject\Id;
use App\Shared\Transfer\AttributeValueTransfer;

final class IntegerCreator implements AttributeCreatorInterface
{
    private const TYPE_NAME = 'integer';

    public function __construct(
        private readonly AttributeValueRepositoryInterface $attributeValueRepository
    ) {
    }

    public function create(
        AttributeValueTransfer $transfer,
        Attribute $attribute,
        User $creator,
        ?Id $parentId = null,
    ): AttributeValue {
        return $this->attributeValueRepository->create(
            $attribute,
            self::TYPE_NAME,
            (string) $transfer->getValue(),
            $creator,
            $parentId
        );
    }
}

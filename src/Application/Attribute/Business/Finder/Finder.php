<?php

declare(strict_types=1);

namespace App\Application\Attribute\Business\Finder;

use App\Domain\Model\Attribute;
use App\Domain\Model\AttributeValue\Code;
use App\Domain\Repository\AttributeRepositoryInterface;
use App\Domain\ValueObject\Id;
use App\Shared\Exception\AttributeNotFound;
use App\Shared\Transfer\GetAttributeTransfer;
use Generator;

final class Finder implements FinderInterface
{
    public function __construct(
        private readonly AttributeRepositoryInterface $repository,
    ) {
    }

    public function getList(int $page, int $size): Generator
    {
        return $this->repository->list($page, $size);
    }

    public function getTotalCount(): int
    {
        return $this->repository->totalCount();
    }

    public function getById(GetAttributeTransfer $transfer): ?Attribute
    {
        if (null === $attribute = $this->repository->findById(Id::fromString($transfer->getId()))) {
            throw new AttributeNotFound();
        }

        return $attribute;
    }
}

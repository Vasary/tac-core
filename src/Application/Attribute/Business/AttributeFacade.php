<?php

declare(strict_types = 1);

namespace App\Application\Attribute\Business;

use App\Application\Attribute\Business\Creator\CreatorInterface;
use App\Application\Attribute\Business\Finder\FinderInterface;
use App\Application\Attribute\Business\Updater\UpdaterInterface;
use App\Domain\Model\Attribute;
use App\Shared\Transfer\AttributeCreateTransfer;
use App\Shared\Transfer\DeleteAttributeTransfer;
use App\Shared\Transfer\GetAttributeTransfer;
use App\Shared\Transfer\UpdateAttributeTransfer;
use Generator;

final class AttributeFacade implements AttributeFacadeInterface
{
    public function __construct(
        private readonly CreatorInterface $creator,
        private readonly FinderInterface $finder,
        private readonly UpdaterInterface $updater
    ) {
    }

    public function create(AttributeCreateTransfer $transfer): Attribute
    {
        return $this->creator->create($transfer);
    }

    public function update(UpdateAttributeTransfer $transfer): Attribute
    {
        return $this->updater->update($transfer);
    }

    public function getList(int $page, int $size): Generator
    {
        return $this->finder->getList($page, $size);
    }

    public function getTotalCount(): int
    {
        return $this->finder->getTotalCount();
    }

    public function getById(GetAttributeTransfer $transfer): ?Attribute
    {
        return $this->finder->getById($transfer);
    }

    public function delete(DeleteAttributeTransfer $transfer): void
    {
        $this->updater->delete($transfer);
    }
}

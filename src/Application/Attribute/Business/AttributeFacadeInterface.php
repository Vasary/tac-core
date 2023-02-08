<?php

declare(strict_types = 1);

namespace App\Application\Attribute\Business;

use App\Domain\Model\Attribute;
use App\Shared\Transfer\AttributeCreateTransfer;
use App\Shared\Transfer\DeleteAttributeTransfer;
use App\Shared\Transfer\GetAttributeTransfer;
use App\Shared\Transfer\UpdateAttributeTransfer;
use Generator;

interface AttributeFacadeInterface
{
    public function create(AttributeCreateTransfer $transfer): Attribute;

    public function getList(int $page, int $size): Generator;

    public function update(UpdateAttributeTransfer $transfer): Attribute;

    public function getById(GetAttributeTransfer $transfer): ?Attribute;

    public function getTotalCount(): int;

    public function delete(DeleteAttributeTransfer $transfer): void;
}

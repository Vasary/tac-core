<?php

declare(strict_types = 1);

namespace App\Application\Category\Business\Creator;

use App\Domain\Model\Category;
use App\Shared\Transfer\CategoryCreateTransfer;

interface CreatorInterface
{
    public function create(CategoryCreateTransfer $transfer): Category;
}

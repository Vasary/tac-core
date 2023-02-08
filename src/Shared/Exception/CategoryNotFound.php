<?php

declare(strict_types = 1);

namespace App\Shared\Exception;

use App\Application\Shared\Contract\ApplicationException;
use InvalidArgumentException;

final class CategoryNotFound extends InvalidArgumentException implements ApplicationException
{
    public function __construct()
    {
        parent::__construct('Category not found', 404);
    }
}

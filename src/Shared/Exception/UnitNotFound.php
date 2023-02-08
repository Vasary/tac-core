<?php

declare(strict_types = 1);

namespace App\Shared\Exception;

use App\Application\Shared\Contract\ApplicationException;
use InvalidArgumentException;

final class UnitNotFound extends InvalidArgumentException implements ApplicationException
{
    public function __construct()
    {
        parent::__construct('Unit not found', 404);
    }
}

<?php

declare(strict_types = 1);

namespace App\Application\Shared\Service\Locale;

use App\Domain\ValueObject\Locale;

interface LocalServiceInterface
{
    public function getCurrentLocale(): Locale;
}

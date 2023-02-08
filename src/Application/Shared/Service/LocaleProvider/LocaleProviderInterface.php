<?php

declare(strict_types = 1);

namespace App\Application\Shared\Service\LocaleProvider;

interface LocaleProviderInterface
{
    public function getLocale(): string;
}

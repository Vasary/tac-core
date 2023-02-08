<?php

declare(strict_types = 1);

namespace App\Application\Shared\Service\Locale;

use App\Application\Shared\Service\LocaleProvider\LocaleProviderInterface;
use App\Domain\ValueObject\Locale;

final class LocaleService implements LocalServiceInterface
{
    public function __construct(private readonly LocaleProviderInterface $localeProvider)
    {
    }

    public function getCurrentLocale(): Locale
    {
        return new Locale($this->localeProvider->getLocale());
    }
}

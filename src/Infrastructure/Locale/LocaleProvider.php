<?php

declare(strict_types=1);

namespace App\Infrastructure\Locale;

use App\Application\Shared\Service\LocaleProvider\LocaleProviderInterface;
use Symfony\Component\HttpFoundation\RequestStack;

final class LocaleProvider implements LocaleProviderInterface
{
    private const FALLBACK_LOCALE = 'en';

    public function __construct(private readonly RequestStack $requestStack)
    {
    }

    public function getLocale(): string
    {
        return $this->requestStack->getMainRequest()?->getLocale() ?? self::FALLBACK_LOCALE;
    }
}

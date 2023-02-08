<?php

declare(strict_types = 1);

namespace App\Tests\Application\Service\Locale;

use App\Application\Shared\Service\Locale\LocaleService;
use App\Application\Shared\Service\Locale\LocalServiceInterface;
use App\Application\Shared\Service\LocaleProvider\LocaleProviderInterface;
use App\Infrastructure\Test\AbstractUnitTestCase;
use Mockery;

final class LocaleServiceTest extends AbstractUnitTestCase
{
    public function testShouldSuccessfullyRetrieveLocale(): void
    {
        $service = $this->createService('en');

        $this->assertEquals('en', $service->getCurrentLocale());
    }

    private function createService(?string $return): LocalServiceInterface
    {
        $mock = Mockery::mock(LocaleProviderInterface::class);
        $mock
            ->shouldReceive('getLocale')
            ->andReturn($return)
        ;

        return new LocaleService($mock);
    }
}

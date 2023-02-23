<?php

declare(strict_types=1);

namespace App\Tests\Presentation\HealthCheck;

use App\Application\HealthCheck\Business\Checker\CheckerInterface;
use App\Application\HealthCheck\Business\Checker\Response;
use App\Infrastructure\Test\AbstractWebTestCase;
use Mockery;

final class HealthCheckControllerTest extends AbstractWebTestCase
{
    public function testShouldSuccessfullyRetrieveOkResponse(): void
    {
        $checkerMock = Mockery::mock(CheckerInterface::class);
        $checkerMock
            ->shouldReceive('check')
            ->once()
            ->andReturn([new Response('Mock checker', true, 'ok')]);

        self::getContainer()->set(CheckerInterface::class, $checkerMock);

        $response = $this->sendRequest('GET', '/health/check');

        $content = (string)$response->getContent();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJson($content);
    }

    public function testShouldSuccessfullyRetrieveErrorResponse(): void
    {
        $checkerMock = Mockery::mock(CheckerInterface::class);
        $checkerMock
            ->shouldReceive('check')
            ->once()
            ->andReturn([new Response('Mock checker', false, 'ok')]);

        self::getContainer()->set(CheckerInterface::class, $checkerMock);

        $response = $this->sendRequest('GET', '/health/check');

        $content = (string)$response->getContent();

        $this->assertEquals(500, $response->getStatusCode());
        $this->assertJson($content);
    }
}

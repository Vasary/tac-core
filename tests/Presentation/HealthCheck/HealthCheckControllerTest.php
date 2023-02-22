<?php

declare(strict_types = 1);

namespace App\Tests\Presentation\HealthCheck;

use App\Infrastructure\Test\AbstractWebTestCase;

final class HealthCheckControllerTest extends AbstractWebTestCase
{
    public function testShouldSuccessfullyRetrieveOkResponse(): void
    {
        $response = $this->sendRequest('GET', '/health/check');

        $content = (string)$response->getContent();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJson($content);
    }
}

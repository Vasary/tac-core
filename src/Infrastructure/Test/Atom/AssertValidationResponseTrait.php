<?php

declare(strict_types=1);

namespace App\Infrastructure\Test\Atom;

use App\Infrastructure\Json\Json;
use Symfony\Component\HttpFoundation\Response;

trait AssertValidationResponseTrait
{
    public function assertValidationError(Response $response, int $statusCode, string $property, string $message): void
    {
        $content = (string) $response->getContent();
        $decodedContent = Json::decode($content);

        $this->assertJson($content);

        $this->assertEquals($statusCode, $response->getStatusCode());

        $this->assertArrayHasKey('code', $decodedContent);
        $this->assertArrayHasKey('message', $decodedContent);
        $this->assertArrayHasKey('constraints', $decodedContent);

        $this->assertEquals('Validation fail', $decodedContent['message']);
        $this->assertGreaterThan(0, $decodedContent['constraints']);

        $iteration = 0;
        foreach ($decodedContent['constraints'] as $error) {
            if ($error['property'] === $property) {
                $this->assertEquals($message, $error['message']);
                ++$iteration;
            }
        }

        $this->assertEquals(1, $iteration);
    }
}

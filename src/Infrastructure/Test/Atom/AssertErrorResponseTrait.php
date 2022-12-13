<?php

declare(strict_types=1);

namespace App\Infrastructure\Test\Atom;

use App\Infrastructure\Response\JsonResponse;

trait AssertErrorResponseTrait
{
    public function assertErrorResponse(JsonResponse $response, int $expectedCode, string $expectedMessage): void
    {
        $content = (string) $response->getContent();

        $this->assertResponseHasHeader('Content-Type');
        $this->assertResponseHeaderSame('Content-Type', 'application/json');

        $this->assertJson($content);
        $this->assertEquals($expectedCode, $response->getStatusCode());

        $decodedContent = json_decode($content, true);
        $this->assertIsArray($decodedContent);

        $this->assertArrayHasKey('code', $decodedContent);
        $this->assertArrayHasKey('message', $decodedContent);
        $this->assertEquals($expectedCode, $decodedContent['code']);
        $this->assertEquals($expectedMessage, $decodedContent['message']);
    }
}

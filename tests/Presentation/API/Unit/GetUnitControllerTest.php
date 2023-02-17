<?php

declare(strict_types = 1);

namespace App\Tests\Presentation\API\Unit;

use App\Infrastructure\Json\Json;
use App\Infrastructure\Test\AbstractWebTestCase;
use App\Infrastructure\Test\Atom\AssertEventTrait;
use App\Infrastructure\Test\Context\Model\UnitContext;
use App\Infrastructure\Test\Context\Model\UserContext;

final class GetUnitControllerTest extends AbstractWebTestCase
{
    use AssertEventTrait;

    public function testShouldSuccessfullyGetUnit(): void
    {
        $this->expectEvents();

        $user = UserContext::create()();
        $unit = UnitContext::create()();

        $this->load($user, $unit);
        $this->withUser($user);

        $response = $this->sendRequest('GET', '/api/units/' . $unit->getId());

        $responseContent = (string)$response->getContent();

        $decodedContent = json_decode($responseContent, true);

        self::assertResponseStatusCodeSame(200);
        $this->assertJson($responseContent);

        $this->assertArrayHasKey('id', $decodedContent);
        $this->assertArrayHasKey('name', $decodedContent);
        $this->assertArrayHasKey('alias', $decodedContent);
        $this->assertArrayHasKey('suggestions', $decodedContent);
        $this->assertArrayHasKey('creator', $decodedContent);
        $this->assertArrayHasKey('createdAt', $decodedContent);
        $this->assertArrayHasKey('updatedAt', $decodedContent);
        $this->assertArrayHasKey('deletedAt', $decodedContent);

        $this->assertEquals('14c374a0-e8a9-448c-93e5-fea748240266', $decodedContent['id']);
        $this->assertEquals('name', $decodedContent['name']);
        $this->assertEquals('alias', $decodedContent['alias']);
        $this->assertCount(3, $decodedContent['suggestions']);

        foreach ($decodedContent['suggestions'] as $suggestion) {
            $this->assertIsInt($suggestion);
        }
    }

    public function testShouldGetNotFoundError(): void
    {
        $this->expectEvents();

        $user = UserContext::create()();

        $this->load($user);
        $this->withUser($user);

        $response = $this->sendRequest('GET', '/api/units/' . $this->faker->uuidv4());

        $responseContent = (string)$response->getContent();

        self::assertResponseStatusCodeSame(404);
        $this->assertJson($responseContent);

        $decodedContent = Json::decode($responseContent);

        $this->assertArrayHasKey('code', $decodedContent);
        $this->assertArrayHasKey('message', $decodedContent);
        $this->assertEquals(404, $decodedContent['code']);
        $this->assertEquals('Unit not found', $decodedContent['message']);
    }
}

<?php

declare(strict_types = 1);

namespace App\Tests\Presentation\API\Unit;

use App\Domain\Model\Unit;
use App\Infrastructure\Json\Json;
use App\Infrastructure\Test\AbstractWebTestCase;
use App\Infrastructure\Test\Atom\AssertEventTrait;
use App\Infrastructure\Test\Context\Model\UnitContext;
use App\Infrastructure\Test\Context\Model\UserContext;

final class DeleteUnitControllerTest extends AbstractWebTestCase
{
    use AssertEventTrait;

    private const EVENT_BODY = <<<JSON
{"unit":{"id":"14c374a0-e8a9-448c-93e5-fea748240266","name":"name","alias":"alias","suggestions":[10,20,50],"creator":"foo@bar.com","createdAt":"2022-01-01T00:00:00+00:00","updatedAt":"2022-01-01T00:00:00+00:00","deletedAt":null}}
JSON;

    public function testShouldSuccessfullyDeleteUnit(): void
    {
        $user = UserContext::create()();
        $unit = UnitContext::create()();

        $this->assertEvent([
            ['unit.removed', self::EVENT_BODY],
        ]);

        $this->load($user, $unit);
        $this->withUser($user);

        $this->browser->request('DELETE', '/api/units/' . $unit->getId());

        $responseContent = (string)$this->browser->getResponse()->getContent();

        $decodedContent = json_decode($responseContent, true);

        self::assertResponseStatusCodeSame(200);
        $this->assertJson($responseContent);

        $this->assertDatabaseCount(Unit::class, 0);
        $this->assertEquals(200, $decodedContent['status']);
        $this->assertEquals('Successfully removed', $decodedContent['message']);
    }

    public function testShouldGetUnitNotFoundError(): void
    {
        $this->assertEvent();

        $this->withUser(UserContext::create()());

        $this->browser->request('DELETE', '/api/units/' . $this->faker->uuidv4());

        $responseContent = (string)$this->browser->getResponse()->getContent();

        self::assertResponseStatusCodeSame(404);
        $this->assertJson($responseContent);

        $decodedContent = Json::decode($responseContent);

        $this->assertArrayHasKey('code', $decodedContent);
        $this->assertArrayHasKey('message', $decodedContent);
        $this->assertEquals(404, $decodedContent['code']);
        $this->assertEquals('Unit not found', $decodedContent['message']);
    }
}

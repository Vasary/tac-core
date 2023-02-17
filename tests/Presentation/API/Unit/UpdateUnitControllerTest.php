<?php

declare(strict_types = 1);

namespace App\Tests\Presentation\API\Unit;

use App\Domain\Model\Unit;
use App\Infrastructure\Json\Json;
use App\Infrastructure\Test\AbstractWebTestCase;
use App\Infrastructure\Test\Atom\AssertEventTrait;
use App\Infrastructure\Test\Context\Model\UnitContext;
use App\Infrastructure\Test\Context\Model\UserContext;

final class UpdateUnitControllerTest extends AbstractWebTestCase
{
    use AssertEventTrait;

    private const GLOSSARY_EVENT_NAME_BODY = <<<JSON
{"glossary":{"objectId":"14c374a0-e8a9-448c-93e5-fea748240266","field":"name","value":"Kilograms","locale":"en"}}
JSON;

    private const GLOSSARY_EVENT_NANE_ALIAS = <<<JSON
{"glossary":{"objectId":"14c374a0-e8a9-448c-93e5-fea748240266","field":"alias","value":"kg","locale":"en"}}
JSON;

    private const UNIT_EVENT_UPDATE_NAME = <<<JSON
{"unit":{"id":"14c374a0-e8a9-448c-93e5-fea748240266","name":"Kilograms","alias":"alias","suggestions":[10,20,50],"creator":"mock|10101011","createdAt":"2022-01-01T00:00:00+00:00","updatedAt":"2022-10-01T00:00:00+00:00","deletedAt":null}}
JSON;

    private const UNIT_EVENT_UPDATE_ALIAS = <<<JSON
{"unit":{"id":"14c374a0-e8a9-448c-93e5-fea748240266","name":"Kilograms","alias":"kg","suggestions":[10,20,50],"creator":"mock|10101011","createdAt":"2022-01-01T00:00:00+00:00","updatedAt":"2022-10-01T00:00:00+00:00","deletedAt":null}}
JSON;

    private const UNIT_EVENT_UPDATE_SUGGESTIONS = <<<JSON
{"unit":{"id":"14c374a0-e8a9-448c-93e5-fea748240266","name":"Kilograms","alias":"kg","suggestions":[100,250,500,600],"creator":"mock|10101011","createdAt":"2022-01-01T00:00:00+00:00","updatedAt":"2022-10-01T00:00:00+00:00","deletedAt":null}}
JSON;

    public function testShouldSuccessfullyUpdateUnit(): void
    {
        $user = UserContext::create()();
        $unit = UnitContext::create()();

        $this->load($user, $unit);
        $this->withUser($user);

        $this->expectEvents([
            ['glossary.updated', self::GLOSSARY_EVENT_NAME_BODY],
            ['glossary.updated', self::GLOSSARY_EVENT_NANE_ALIAS],
            ['unit.updated', self::UNIT_EVENT_UPDATE_NAME],
            ['unit.updated', self::UNIT_EVENT_UPDATE_ALIAS],
            ['unit.updated', self::UNIT_EVENT_UPDATE_SUGGESTIONS],
        ]);

        $this->freezeTime('2022-10-01');

        $response = $this->sendRequest('PUT', '/api/units', [
                'id' => (string)$unit->getId(),
                'name' => 'Kilograms',
                'alias' => 'kg',
                'suggestions' => [
                    100,
                    250,
                    500,
                    600,
                ],
            ]
        );

        $responseContent = (string)$response->getContent();

        $decodedContent = json_decode($responseContent, true);

        self::assertResponseStatusCodeSame(200);
        $this->assertJson($responseContent);
        $this->assertDatabaseCount(Unit::class, 1);

        $this->assertArrayHasKey('id', $decodedContent);
        $this->assertArrayHasKey('name', $decodedContent);
        $this->assertArrayHasKey('alias', $decodedContent);
        $this->assertArrayHasKey('suggestions', $decodedContent);
        $this->assertArrayHasKey('creator', $decodedContent);
        $this->assertArrayHasKey('createdAt', $decodedContent);
        $this->assertArrayHasKey('updatedAt', $decodedContent);
        $this->assertArrayHasKey('deletedAt', $decodedContent);
        $this->assertEquals('Kilograms', $decodedContent['name']);
        $this->assertEquals('kg', $decodedContent['alias']);
        $this->assertCount(4, $decodedContent['suggestions']);
        $this->assertEquals('2022-10-01T00:00:00+00:00', $decodedContent['updatedAt']);
        $this->assertNull($decodedContent['deletedAt']);

        foreach ($decodedContent['suggestions'] as $suggestion) {
            $this->assertIsInt($suggestion);
        }
    }

    public function testShouldGetUnitNotFoundError(): void
    {
        $this->expectEvents();

        $user = UserContext::create()();

        $this->load($user);
        $this->withUser($user);

        $response = $this->sendRequest('PUT', '/api/units', [
                'id' => $this->faker->uuidv4(),
                'name' => 'Kilograms',
                'alias' => 'kg',
                'suggestions' => [
                    100,
                    250,
                    500,
                    600,
                ],
            ]
        );

        $responseContent = (string)$response->getContent();
        $decodedContent = Json::decode($responseContent);

        self::assertResponseStatusCodeSame(404);
        $this->assertArrayHasKey('code', $decodedContent);
        $this->assertArrayHasKey('message', $decodedContent);
        $this->assertEquals(404, $decodedContent['code']);
        $this->assertEquals('Unit not found', $decodedContent['message']);
    }
}

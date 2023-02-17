<?php

declare(strict_types = 1);

namespace App\Tests\Presentation\API\Unit;

use App\Domain\Model\Glossary;
use App\Domain\Model\Unit;
use App\Infrastructure\Test\AbstractWebTestCase;
use App\Infrastructure\Test\Atom\AssertEventTrait;
use App\Infrastructure\Test\Context\Model\UserContext;

final class CreateUnitControllerTest extends AbstractWebTestCase
{
    use AssertEventTrait;

    private const GLOSSARY_NAME_EVENT_BODY = <<<JSON
{"glossary":{"objectId":"6fde348e-cd2d-427e-ad4f-7faf8a4dd7e3","field":"name","value":"Kilograms","locale":"en"}}
JSON;

    private const GLOSSARY_ALIAS_EVENT_BODY = <<<JSON
{"glossary":{"objectId":"6fde348e-cd2d-427e-ad4f-7faf8a4dd7e3","field":"alias","value":"kg","locale":"en"}}
JSON;

    private const UNIT_EVENT_BODY = <<<JSON
{"unit":{"id":"6fde348e-cd2d-427e-ad4f-7faf8a4dd7e3","name":"Kilograms","alias":"kg","suggestions":[100,250,500],"creator":"mock|10101011","createdAt":"1986-06-05T00:00:00+00:00","updatedAt":"1986-06-05T00:00:00+00:00","deletedAt":null}}
JSON;


    protected static array $ids = [
        '6fde348e-cd2d-427e-ad4f-7faf8a4dd7e3',
        '7066da80-0f0e-4285-a70f-9a7ae4d86fdc',
        '1b74967b-dc2e-4c56-948e-29e3239a81da',
    ];

    public function testShouldSuccessfullyCreateNewUnit(): void
    {
        $this->expectEvents([
            ['glossary.created', self::GLOSSARY_NAME_EVENT_BODY],
            ['glossary.created', self::GLOSSARY_ALIAS_EVENT_BODY],
            ['unit.created', self::UNIT_EVENT_BODY],
        ]);

        $user = UserContext::create()();

        $this->freezeTime('1986-06-05');

        $this->load($user);
        $this->withUser($user);

        $response = $this->sendRequest('POST', '/api/units', [
                'name' => 'Kilograms',
                'alias' => 'kg',
                'suggestions' => [
                    100,
                    250,
                    500,
                ],
            ],
        );

        $responseContent = (string)$response->getContent();

        $decodedContent = json_decode($responseContent, true);

        self::assertResponseStatusCodeSame(201);
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
        $this->assertCount(3, $decodedContent['suggestions']);
        $this->assertDatabaseCount(Glossary::class, 2, useSoftDeleteFilter: false);
        $this->assertDatabaseCount(Unit::class, 1);
        $this->assertEquals($decodedContent['createdAt'], $decodedContent['updatedAt']);
        $this->assertEquals('1986-06-05T00:00:00+00:00', $decodedContent['createdAt']);

        foreach ($decodedContent['suggestions'] as $suggestion) {
            $this->assertIsInt($suggestion);
        }
    }
}

<?php

declare(strict_types = 1);

namespace App\Tests\Presentation\API\Attributes;

use App\Domain\Model\Attribute\Type\IntegerType;
use App\Infrastructure\Json\Json;
use App\Infrastructure\Test\AbstractWebTestCase;
use App\Infrastructure\Test\Atom\AssertEventTrait;
use App\Infrastructure\Test\Context\Model\AttributeContext;
use App\Infrastructure\Test\Context\Model\UserContext;

final class UpdateAttributesControllerTest extends AbstractWebTestCase
{
    use AssertEventTrait;

    private const EVENT_GLOSSARY_NAME = <<<JSON
{"glossary":{"objectId":"888c23c6-06fe-4a95-a66c-f292da2f7607","field":"name","value":"Hello world","locale":"en"}}
JSON;

    private const EVENT_GLOSSARY_DESCRIPTION = <<<JSON
{"glossary":{"objectId":"888c23c6-06fe-4a95-a66c-f292da2f7607","field":"description","value":"my description","locale":"en"}}
JSON;

    private const EVENT_NAME = <<<JSON
{"attribute":{"id":"888c23c6-06fe-4a95-a66c-f292da2f7607","code":"name","name":"Hello world","type":"integer","description":"description","creator":"mock|10101011","createdAt":"2022-01-01T00:00:00+00:00","updatedAt":"2022-10-01T00:00:00+00:00","deletedAt":null}}
JSON;

    private const EVENT_DESCRIPTION = <<<JSON
{"attribute":{"id":"888c23c6-06fe-4a95-a66c-f292da2f7607","code":"name","name":"Hello world","type":"integer","description":"my description","creator":"mock|10101011","createdAt":"2022-01-01T00:00:00+00:00","updatedAt":"2022-10-01T00:00:00+00:00","deletedAt":null}}
JSON;

    private const EVENT_CODE = <<<JSON
{"attribute":{"id":"888c23c6-06fe-4a95-a66c-f292da2f7607","code":"name","name":"Hello world","type":"integer","description":"my description","creator":"mock|10101011","createdAt":"2022-01-01T00:00:00+00:00","updatedAt":"2022-10-01T00:00:00+00:00","deletedAt":null}}
JSON;

    private const EVENT_TYPE = <<<JSON
{"attribute":{"id":"888c23c6-06fe-4a95-a66c-f292da2f7607","code":"name","name":"Hello world","type":"string","description":"my description","creator":"mock|10101011","createdAt":"2022-01-01T00:00:00+00:00","updatedAt":"2022-10-01T00:00:00+00:00","deletedAt":null}}
JSON;

    public function testShouldSuccessfullyUpdateAttribute(): void
    {
        $this->expectEvents([
            ['glossary.updated', self::EVENT_GLOSSARY_NAME],
            ['glossary.updated', self::EVENT_GLOSSARY_DESCRIPTION],
            ['attribute.updated', self::EVENT_NAME],
            ['attribute.updated', self::EVENT_DESCRIPTION],
            ['attribute.updated', self::EVENT_CODE],
            ['attribute.updated', self::EVENT_TYPE],
        ]);

        $user = (new UserContext())();

        $attributeContext = AttributeContext::create();
        $attributeContext->code = 'name';
        $attributeContext->type = new IntegerType();

        $attribute = $attributeContext();

        $this->freezeTime('2022-10-01');

        $this->load($attribute);
        $this->withUser($user);

        $response = $this->sendRequest('PUT', '/api/attributes', [
            'id' => (string)$attribute->getId(),
            'name' => 'Hello world',
            'description' => 'my description',
            'code' => 'name',
            'type' => 'string',
        ]);

        $responseContent = (string)$response->getContent();

        $this->assertResponseStatusCodeSame(200);
        $this->assertJson($responseContent);

        $decodedContent = Json::decode($responseContent);

        $this->assertEquals((string)$attribute->getId(), $decodedContent['id']);
        $this->assertEquals('name', $decodedContent['code']);
        $this->assertEquals('Hello world', $decodedContent['name']);
        $this->assertEquals('string', $decodedContent['type']);
        $this->assertEquals('my description', $decodedContent['description']);
        $this->assertNull($decodedContent['deletedAt']);
        $this->assertArrayHasKey('createdAt', $decodedContent);
        $this->assertArrayHasKey('updatedAt', $decodedContent);
        $this->assertNotEquals($decodedContent['createdAt'], $decodedContent['updatedAt']);
        $this->assertEquals('2022-01-01T00:00:00+00:00', $decodedContent['createdAt']);
        $this->assertEquals('2022-10-01T00:00:00+00:00', $decodedContent['updatedAt']);
    }

    public function testShouldGetNotFoundError(): void
    {
        $this->expectEvents();

        $user = UserContext::create()();
        $this->withUser($user);
        $this->load($user);

        $response = $this->sendRequest('PUT', '/api/attributes', [
            'id' => $this->faker->uuidv4(),
            'name' => 'Hello world',
            'description' => 'my description',
            'code' => 'name',
            'type' => 'string',
        ]);

        $responseContent = (string)$response->getContent();
        $decodedContent = Json::decode($responseContent);

        $this->assertResponseStatusCodeSame(404);
        $this->assertJson($responseContent);

        $this->assertArrayHasKey('code', $decodedContent);
        $this->assertArrayHasKey('message', $decodedContent);
        $this->assertEquals(404, $decodedContent['code']);
        $this->assertEquals('Attribute not found', $decodedContent['message']);
    }
}

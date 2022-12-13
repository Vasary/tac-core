<?php

declare(strict_types=1);

namespace App\Tests\Presentation\API\Attributes;

use App\Infrastructure\Test\AbstractWebTestCase;
use App\Infrastructure\Test\Atom\AssertAttributeTrait;
use App\Infrastructure\Test\Atom\AssertEventTrait;
use App\Infrastructure\Test\Atom\AssertValidationResponseTrait;
use App\Infrastructure\Test\Context\Model\UserContext;

final class CreateNewAttributeTest extends AbstractWebTestCase
{
    use AssertAttributeTrait, AssertValidationResponseTrait, AssertEventTrait;

    private const GLOSSARY_NAME = <<<JSON
{"glossary":{"objectId":"ea996212-e88c-4323-aeac-a9a008edd515","field":"name","value":"My cool attribute","locale":"en"}}
JSON;

    private const GLOSSARY_DESCRIPTION = <<<JSON
{"glossary":{"objectId":"ea996212-e88c-4323-aeac-a9a008edd515","field":"description","value":"This is my cool description text","locale":"en"}}
JSON;

    private const ATTRIBUTE_EVENT = <<<JSON
{"attribute":{"id":"ea996212-e88c-4323-aeac-a9a008edd515","code":"name","name":"My cool attribute","type":"string","description":"This is my cool description text","creator":{"identifier":"foo@bar.com"},"createdAt":"2022-09-01T00:00:00+00:00","updatedAt":"2022-09-01T00:00:00+00:00","deletedAt":null}}
JSON;

    protected static array $ids = [
        'ea996212-e88c-4323-aeac-a9a008edd515',
        '3dc0a3c9-9a8c-4b50-9e49-d27e1dbf414d',
        '424e0b28-cab1-44ce-b221-85b6ecca88a7',
    ];

    public function testShouldSuccessfullyCreateNewAttribute(): void
    {
        $this->assertEvent([
            ['glossary.created', self::GLOSSARY_NAME],
            ['glossary.created', self::GLOSSARY_DESCRIPTION],
            ['attribute.created', self::ATTRIBUTE_EVENT],
        ]);

        $this->withUser((new UserContext())());

        $name = 'My cool attribute';
        $text = 'This is my cool description text';

        $this->freezeTime();

        $this->browser->jsonRequest('POST', '/api/attributes', [
            'code' => 'name',
            'name' => $name,
            'description' => $text,
            'type' => 'string',
        ]);

        $responseContent = (string)$this->browser->getResponse()->getContent();

        $this->assertResponseStatusCodeSame(201);
        $this->assertJson($responseContent);

        $decodedContent = json_decode($responseContent, true, 512, \JSON_THROW_ON_ERROR);

        $this->assertAttribute($decodedContent);

        $this->assertEquals('name', $decodedContent['code']);
        $this->assertEquals($name, $decodedContent['name']);
        $this->assertEquals($text, $decodedContent['description']);
        $this->assertEquals('string', $decodedContent['type']);
    }
}

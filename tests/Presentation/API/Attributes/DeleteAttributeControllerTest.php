<?php

declare(strict_types = 1);

namespace App\Tests\Presentation\API\Attributes;

use App\Domain\Model\Attribute;
use App\Infrastructure\Json\Json;
use App\Infrastructure\Test\AbstractWebTestCase;
use App\Infrastructure\Test\Atom\AssertEventTrait;
use App\Infrastructure\Test\Context\Model\AttributeContext;
use App\Infrastructure\Test\Context\Model\UserContext;

final class DeleteAttributeControllerTest extends AbstractWebTestCase
{
    use AssertEventTrait;

    private const EVENT = <<<JSON
{"attribute":{"id":"888c23c6-06fe-4a95-a66c-f292da2f7607","code":"name","name":"name","type":"string","description":"description","creator":"foo@bar.com","createdAt":"2022-01-01T00:00:00+00:00","updatedAt":"2022-01-01T00:00:00+00:00","deletedAt":null}}
JSON;

    public function testShouldSuccessfullyRemoveExistedAttribute(): void
    {
        $this->assertEvent([
            ['attribute.removed', self::EVENT],
        ]);

        $user = UserContext::create()();
        $this->withUser($user);

        $attributeContext = AttributeContext::create();
        $attributeContext->user = $user;
        $attribute = $attributeContext();

        $this->load($attribute);

        $this->browser->request('DELETE', '/api/attributes/' . $attribute->getId());

        $responseContent = (string)$this->browser->getResponse()->getContent();

        $this->assertResponseStatusCodeSame(200);
        $this->assertJson($responseContent);
        $this->assertDatabaseCount(Attribute::class, 0);

        $decodedContent = json_decode($responseContent, true);

        $this->assertArrayHasKey('status', $decodedContent);
        $this->assertArrayHasKey('message', $decodedContent);
        $this->assertEquals(200, $decodedContent['status']);
        $this->assertEquals('Successfully removed', $decodedContent['message']);
    }

    public function testShouldGetNotFoundError(): void
    {
        $this->assertEvent();

        $this->withUser(UserContext::create()());

        $this->browser->request('DELETE', '/api/attributes/' . $this->faker->uuidv4());

        $responseContent = (string)$this->browser->getResponse()->getContent();
        $decodedContent = Json::decode($responseContent);

        $this->assertResponseStatusCodeSame(404);
        $this->assertJson($responseContent);

        $this->assertArrayHasKey('code', $decodedContent);
        $this->assertArrayHasKey('message', $decodedContent);
        $this->assertEquals(404, $decodedContent['code']);
        $this->assertEquals('Attribute not found', $decodedContent['message']);
    }
}

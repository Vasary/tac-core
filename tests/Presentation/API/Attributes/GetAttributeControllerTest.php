<?php

declare(strict_types = 1);

namespace App\Tests\Presentation\API\Attributes;

use App\Infrastructure\Json\Json;
use App\Infrastructure\Test\AbstractWebTestCase;
use App\Infrastructure\Test\Atom\AssertAttributeTrait;
use App\Infrastructure\Test\Atom\AssertEventTrait;
use App\Infrastructure\Test\Context\Model\AttributeContext;
use App\Infrastructure\Test\Context\Model\UserContext;

final class GetAttributeControllerTest extends AbstractWebTestCase
{
    use AssertAttributeTrait, AssertEventTrait;

    public function testShouldRetrieveAttribute(): void
    {
        $this->expectEvents();
        $user = UserContext::create()();
        $this->withUser($user);

        $attributeContext = AttributeContext::create();
        $attributeContext->user = $user;
        $attribute = $attributeContext();

        $this->load($attribute, $user);

        $response = $this->sendRequest('GET', '/api/attributes/' . $attribute->getId());

        $responseContent = (string) $response->getContent();

        $decoded = json_decode($responseContent, true);

        $this->assertResponseStatusCodeSame(200);
        $this->assertJson($responseContent);
        $this->assertAttribute($decoded);
    }

    public function testShouldGetNotFoundError(): void
    {
        $user = UserContext::create()();

        $this->withUser($user);
        $this->load($user);

        $response = $this->sendRequest('GET', '/api/attributes/' . $this->faker->uuidv4());

        $responseContent = (string) $response->getContent();

        $decodedContent = Json::decode($responseContent);

        $this->assertArrayHasKey('code', $decodedContent);
        $this->assertArrayHasKey('message', $decodedContent);
        $this->assertEquals(404, $decodedContent['code']);
        $this->assertEquals('Attribute not found', $decodedContent['message']);
    }
}

<?php

declare(strict_types = 1);

namespace App\Tests\Presentation\API\AttributeValue;

use App\Domain\Model\AttributeValue;
use App\Infrastructure\Json\Json;
use App\Infrastructure\Test\AbstractWebTestCase;
use App\Infrastructure\Test\Atom\AssertAttributeTrait;
use App\Infrastructure\Test\Atom\AssertEventTrait;
use App\Infrastructure\Test\Context\Model\AttributeValueContext;
use App\Infrastructure\Test\Context\Model\UserContext;

final class GetAttributeValuesControllerTest extends AbstractWebTestCase
{
    use AssertEventTrait, AssertAttributeTrait;

    public function testShouldRetrieveAllAttributeValues(): void
    {
        $this->assertEvent();

        $user = UserContext::create()();

        $attributeOne = $this->faker->attribute();
        $attributeTwo = $this->faker->attribute();

        $firstAttributeValueContext = AttributeValueContext::create();
        $firstAttributeValueContext->id = $this->faker->uuidv4();
        $firstAttributeValueContext->attribute = $attributeOne;

        $secondAttributeValueContext = AttributeValueContext::create();
        $secondAttributeValueContext->id = $this->faker->uuidv4();
        $secondAttributeValueContext->attribute = $attributeTwo;

        $this->load($user, $attributeOne, $attributeTwo, $firstAttributeValueContext(), $secondAttributeValueContext());
        $this->withUser($user);

        $this->browser->request('GET', '/api/attributes/values?page=1&size=1');

        $responseContent = (string)$this->browser->getResponse()->getContent();
        $content = Json::decode($responseContent);

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(200);
        $this->assertJson($responseContent);
        $this->assertDatabaseCount(AttributeValue::class, 2);
        $this->assertArrayHasKey('items', $content);
        $this->assertArrayHasKey('total', $content);
        $this->assertCount(1, $content['items']);
        $this->assertAttributeValue($content['items'][0]);
    }
}

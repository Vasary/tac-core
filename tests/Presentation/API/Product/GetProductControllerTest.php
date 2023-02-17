<?php

declare(strict_types = 1);

namespace App\Tests\Presentation\API\Product;

use App\Domain\ValueObject\I18N;
use App\Infrastructure\Json\Json;
use App\Infrastructure\Test\AbstractWebTestCase;
use App\Infrastructure\Test\Atom\AssertEventTrait;
use App\Infrastructure\Test\Context\Model\AttributeContext;
use App\Infrastructure\Test\Context\Model\AttributeValueContext;
use App\Infrastructure\Test\Context\Model\CategoryContext;
use App\Infrastructure\Test\Context\Model\ProductContext;
use App\Infrastructure\Test\Context\Model\UserContext;

final class GetProductControllerTest extends AbstractWebTestCase
{
    use AssertEventTrait;

    public function testShouldSuccessfullyRetrieveProduct(): void
    {
        $this->expectNoEvents();

        $user = UserContext::create()();
        $product = ProductContext::create()();

        $this->load(CategoryContext::create()(), $product, $user);

        $this->withUser($user);
        $response = $this->sendRequest('GET', '/api/products/' . $product->getId());

        $responseContent = $response->getContent();

        self::assertResponseStatusCodeSame(200);
        $this->assertJson($responseContent);

        $content = Json::decode($responseContent);

        $this->assertArrayHasKey('id', $content);
        $this->assertArrayHasKey('name', $content);
        $this->assertArrayHasKey('description', $content);
        $this->assertArrayHasKey('creator', $content);
        $this->assertArrayHasKey('createdAt', $content);
        $this->assertArrayHasKey('updatedAt', $content);
        $this->assertArrayHasKey('deletedAt', $content);
        $this->assertArrayHasKey('attributes', $content);
        $this->assertEquals((string)$product->getId(), $content['id']);
        $this->assertEquals((string)$product->getName(), $content['name']);
        $this->assertEquals((string)$product->getDescription(), $content['description']);
        $this->assertNull($product->getDeletedAt());
        $this->assertEquals($product->getCreatedAt()->format(DATE_ATOM), $content['createdAt']);
        $this->assertEquals($product->getUpdatedAt()->format(DATE_ATOM), $content['updatedAt']);
        $this->assertEmpty($content['attributes']);
        $this->assertEquals('2022-01-01T00:00:00+00:00', $content['createdAt']);
        $this->assertEquals('2022-01-01T00:00:00+00:00', $content['updatedAt']);
    }

    public function testShouldSuccessfullyRetrieveProductWithAttributes(): void
    {
        $this->expectNoEvents();

        $attributeContext = AttributeContext::create();
        $categoryContext = CategoryContext::create();
        $productContext = ProductContext::create();
        $userContext = UserContext::create();
        $attributeValueContext = AttributeValueContext::create();

        $category = $categoryContext();
        $user = $userContext();
        $product = $productContext();
        $attribute = $attributeContext();

        $attributeValueContext->attribute = $attribute;
        $attributeValueContext->product = $product;
        $attributeValue = $attributeValueContext();

        $this->load($attribute, $category, $product, $user, $attributeValue);

        $this->withUser($user);
        $response = $this->sendRequest('GET', '/api/products/' . $product->getId());

        $responseContent = $response->getContent();

        self::assertResponseStatusCodeSame(200);
        $this->assertJson($responseContent);

        $decodedContent = Json::decode($responseContent);

        $this->assertArrayHasKey('id', $decodedContent);
        $this->assertArrayHasKey('name', $decodedContent);
        $this->assertArrayHasKey('description', $decodedContent);
        $this->assertArrayHasKey('creator', $decodedContent);
        $this->assertArrayHasKey('createdAt', $decodedContent);
        $this->assertArrayHasKey('updatedAt', $decodedContent);
        $this->assertArrayHasKey('deletedAt', $decodedContent);
        $this->assertArrayHasKey('attributes', $decodedContent);
        $this->assertCount(1, $decodedContent['attributes']);
        $this->assertEquals((string)$product->getId(), $decodedContent['id']);
        $this->assertEquals((string)$product->getName(), $decodedContent['name']);
        $this->assertEquals((string)$product->getDescription(), $decodedContent['description']);
        $this->assertNull($product->getDeletedAt());
        $this->assertEquals($product->getCreatedAt()->format(\DATE_ATOM), $decodedContent['createdAt']);
        $this->assertEquals($product->getUpdatedAt()->format(\DATE_ATOM), $decodedContent['updatedAt']);
        $this->assertNotEmpty($decodedContent['attributes']);
        $this->assertEquals((string)$attributeValue->getId(), $decodedContent['attributes'][0]['id']);
        $this->assertEquals((string)$attribute->getId(), $decodedContent['attributes'][0]['attribute']['id']);
        $this->assertEquals((string)$attribute->getCode(), $decodedContent['attributes'][0]['attribute']['code']);
        $this->assertEquals((string)$attribute->getType(), $decodedContent['attributes'][0]['attribute']['type']);
        $this->assertEquals((string)$attribute->getName(), $decodedContent['attributes'][0]['attribute']['name']);
        $this->assertEquals((string)$attribute->getDescription(), $decodedContent['attributes'][0]['attribute']['description']);
        $this->assertNull($decodedContent['attributes'][0]['attribute']['value']);
        $this->assertEquals($user->getSsoId(), $decodedContent['attributes'][0]['creator']);
        $this->assertEquals('2022-01-01T00:00:00+00:00', $decodedContent['attributes'][0]['createdAt']);
        $this->assertEquals('2022-01-01T00:00:00+00:00', $decodedContent['attributes'][0]['updatedAt']);
        $this->assertNull($decodedContent['attributes'][0]['deletedAt']);
    }

    public function testShouldSuccessfullyRetrieveProductWithMoreThenOneAttribute(): void
    {
        $this->expectNoEvents();

        $category = CategoryContext::create()();
        $productContext = ProductContext::create();
        $userContext = UserContext::create();

        $user = $userContext();
        $product = $productContext();

        $firstAttributeContext = AttributeContext::create();
        $firstAttribute = $firstAttributeContext();
        $firstAttributeValueContext = AttributeValueContext::create();
        $firstAttributeValueContext->attribute = $firstAttribute;
        $firstAttributeValueContext->product = $product;
        $firstAttributeValue = $firstAttributeValueContext();

        $secondAttributeContext = AttributeContext::create();
        $secondAttributeContext->id = 'dcb3c4dd-f453-43e9-b7ca-884382584b09';

        $secondAttributeContext->name = new I18N('Name');
        $secondAttributeContext->description = new I18N('Description');
        $secondAttributeContext->code = 'surname';

        $secondAttribute = $secondAttributeContext();

        $secondAttributeValueContext = AttributeValueContext::create();
        $secondAttributeValueContext->id = '2af05e5f-3ada-47d6-b38f-81342378e07e';
        $secondAttributeValueContext->attribute = $secondAttribute;
        $secondAttributeValueContext->product = $product;
        $secondAttributeValue = $secondAttributeValueContext();

        $this->load($category, $user, $product, $firstAttribute, $secondAttribute, $firstAttributeValue, $secondAttributeValue);

        $this->withUser($user);
        $response = $this->sendRequest('GET', '/api/products/' . $product->getId());

        $responseContent = $response->getContent();

        self::assertResponseStatusCodeSame(200);
        $this->assertJson($responseContent);

        $content = Json::decode($responseContent);

        $this->assertArrayHasKey('id', $content);
        $this->assertArrayHasKey('name', $content);
        $this->assertArrayHasKey('description', $content);
        $this->assertArrayHasKey('creator', $content);
        $this->assertArrayHasKey('createdAt', $content);
        $this->assertArrayHasKey('updatedAt', $content);
        $this->assertArrayHasKey('deletedAt', $content);
        $this->assertArrayHasKey('attributes', $content);
        $this->assertCount(2, $content['attributes']);
        $this->assertEquals('2022-01-01T00:00:00+00:00', $content['createdAt']);
        $this->assertEquals('2022-01-01T00:00:00+00:00', $content['updatedAt']);
    }

    public function testShouldGetNotFoundError(): void
    {
        $this->expectNoEvents();

        $user = UserContext::create()();

        $this->load($user);

        $this->withUser($user);
        $response = $this->sendRequest('GET', '/api/products/' . $this->faker->uuidv4());

        $responseContent = $response->getContent();
        $decodedContent = Json::decode($responseContent);

        $this->assertResponseStatusCodeSame(404);
        $this->assertJson($responseContent);

        $this->assertArrayHasKey('code', $decodedContent);
        $this->assertArrayHasKey('message', $decodedContent);

        $this->assertEquals(404, $decodedContent['code']);
        $this->assertEquals('Product not found', $decodedContent['message']);
    }
}

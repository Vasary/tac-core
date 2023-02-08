<?php

declare(strict_types = 1);

namespace App\Tests\Presentation\API\Product;

use App\Infrastructure\Json\Json;
use App\Infrastructure\Test\AbstractWebTestCase;
use App\Infrastructure\Test\Atom\AssertAttributeTrait;
use App\Infrastructure\Test\Atom\AssertEventTrait;
use App\Infrastructure\Test\Context\Model\CategoryContext;
use App\Infrastructure\Test\Context\Model\ProductContext;
use App\Infrastructure\Test\Context\Model\UserContext;

final class UpdateProductChangeNameAndDescriptionTest extends AbstractWebTestCase
{
    use AssertAttributeTrait, AssertEventTrait;

    private const GLOSSARY_0 = <<<JSON
{"glossary":{"objectId":"1884fcbf-6ade-49a4-b91a-505290ec1e77","field":"name","value":"new name","locale":"en"}}
JSON;

    private const GLOSSARY_1 = <<<JSON
{"glossary":{"objectId":"1884fcbf-6ade-49a4-b91a-505290ec1e77","field":"description","value":"new description","locale":"en"}}
JSON;

    private const PRODUCT_NAME = <<<JSON
{"product":{"id":"1884fcbf-6ade-49a4-b91a-505290ec1e77","name":"new name","description":"description","creator":"foo@bar.com","attributes":[],"category":"6b58caa4-0571-44db-988a-8a75f86b2520","units":[],"createdAt":"2022-01-01T00:00:00+00:00","updatedAt":"2022-09-01T00:00:00+00:00","deletedAt":null}}
JSON;

    private const PRODUCT_DESCRIPTION = <<<JSON
{"product":{"id":"1884fcbf-6ade-49a4-b91a-505290ec1e77","name":"new name","description":"new description","creator":"foo@bar.com","attributes":[],"category":"6b58caa4-0571-44db-988a-8a75f86b2520","units":[],"createdAt":"2022-01-01T00:00:00+00:00","updatedAt":"2022-09-01T00:00:00+00:00","deletedAt":null}}
JSON;

    public function testShouldSuccessfullyUpdateProductNameAdDescription(): void
    {
        $this->freezeTime();

        $this->assertEvent([
            ['glossary.updated', self::GLOSSARY_0],
            ['glossary.updated', self::GLOSSARY_1],
            ['product.updated', self::PRODUCT_NAME],
            ['product.updated', self::PRODUCT_DESCRIPTION],
        ]);

        $category = CategoryContext::create()();

        $productContext = ProductContext::create();

        $user = UserContext::create()();

        $product = $productContext();

        $this->load($user, $category, $product);

        $this->withUser($user);

        $this->browser->jsonRequest('PUT', '/api/products', [
                'id' => (string)$product->getId(),
                'name' => 'new name',
                'description' => 'new description',
                'attributes' => [],
                'units' => [],
            ]
        );

        $content = (string)$this->browser->getResponse()->getContent();

        self::assertResponseStatusCodeSame(200);
        $this->assertJson($content);

        $body = Json::decode($content);

        $this->assertEquals('new name', $body['name']);
        $this->assertEquals('new description', $body['description']);
        $this->assertCount(0, $body['attributes']);
        $this->assertCount(0, $body['units']);
    }
}

<?php

declare(strict_types = 1);

namespace App\Tests\Presentation\API\Product;

use App\Domain\Model\Unit;
use App\Infrastructure\Json\Json;
use App\Infrastructure\Test\AbstractWebTestCase;
use App\Infrastructure\Test\Atom\AssertAttributeTrait;
use App\Infrastructure\Test\Atom\AssertEventTrait;
use App\Infrastructure\Test\Context\Model\CategoryContext;
use App\Infrastructure\Test\Context\Model\ProductContext;
use App\Infrastructure\Test\Context\Model\UnitContext;
use App\Infrastructure\Test\Context\Model\UserContext;

final class UpdateProductUnitsTest extends AbstractWebTestCase
{
    use AssertAttributeTrait, AssertEventTrait;

    private const PRODUCT_UPDATE = <<<JSON
{"product":{"id":"1884fcbf-6ade-49a4-b91a-505290ec1e77","name":"name","description":"description","creator":"mock|10101011","attributes":[],"category":"6b58caa4-0571-44db-988a-8a75f86b2520","units":["14c374a0-e8a9-448c-93e5-fea748240266"],"createdAt":"2022-01-01T00:00:00+00:00","updatedAt":"2022-09-01T00:00:00+00:00","deletedAt":null}}
JSON;

    private const PRODUCT_UPDATE_0 = <<<JSON
{"product":{"id":"1884fcbf-6ade-49a4-b91a-505290ec1e77","name":"name","description":"description","creator":"mock|10101011","attributes":[],"category":"6b58caa4-0571-44db-988a-8a75f86b2520","units":["567d6d64-9977-449b-856e-03b08e821a55","e0aa6ce2-7761-4f5f-be20-296d7dcf137f"],"createdAt":"2022-01-01T00:00:00+00:00","updatedAt":"2022-09-01T00:00:00+00:00","deletedAt":null}}
JSON;

    private const PRODUCT_UPDATE_1 = <<<JSON
{"product":{"id":"1884fcbf-6ade-49a4-b91a-505290ec1e77","name":"name","description":"description","creator":"mock|10101011","attributes":[],"category":"6b58caa4-0571-44db-988a-8a75f86b2520","units":["e0aa6ce2-7761-4f5f-be20-296d7dcf137f"],"createdAt":"2022-01-01T00:00:00+00:00","updatedAt":"2022-09-01T00:00:00+00:00","deletedAt":null}}
JSON;

    private const PRODUCT_UPDATE_2 = <<<JSON
{"product":{"id":"1884fcbf-6ade-49a4-b91a-505290ec1e77","name":"name","description":"description","creator":"mock|10101011","attributes":[],"category":"6b58caa4-0571-44db-988a-8a75f86b2520","units":[],"createdAt":"2022-01-01T00:00:00+00:00","updatedAt":"2022-09-01T00:00:00+00:00","deletedAt":null}}
JSON;

    private const PRODUCT_UPDATE_3 = <<<JSON
{"product":{"id":"1884fcbf-6ade-49a4-b91a-505290ec1e77","name":"name","description":"description","creator":"mock|10101011","attributes":[],"category":"6b58caa4-0571-44db-988a-8a75f86b2520","units":["14c374a0-e8a9-448c-93e5-fea748240266"],"createdAt":"2022-01-01T00:00:00+00:00","updatedAt":"2022-09-01T00:00:00+00:00","deletedAt":null}}
JSON;

    public function testShouldSuccessfullyUpdateProductUnits(): void
    {
        $this->freezeTime();

        $this->expectEvents([
            ['product.updated', self::PRODUCT_UPDATE],
        ]);

        $category = CategoryContext::create()();
        $productContext = ProductContext::create();
        $user = UserContext::create()();
        $unitContext = UnitContext::create();

        $product = $productContext();
        $unit = $unitContext();

        $this->load($user, $category, $product, $unit);
        $this->withUser($user);

        $response = $this->sendRequest('PUT', '/api/products', [
                'id' => (string)$product->getId(),
                'name' => (string)$product->getName(),
                'description' => (string)$product->getDescription(),
                'attributes' => [],
                'units' => [
                    (string)$unit->getId(),
                ],
            ]
        );

        $content = (string)$response->getContent();

        self::assertResponseStatusCodeSame(200);
        $this->assertJson($content);

        $body = Json::decode($content);

        $this->assertEquals('1884fcbf-6ade-49a4-b91a-505290ec1e77', $body['id']);
        $this->assertEquals('name', $body['name']);
        $this->assertEquals('description', $body['description']);
        $this->assertCount(0, $body['attributes']);
        $this->assertCount(1, $body['units']);
    }

    public function testShouldSuccessfullyUpdateProductUnitsReplace(): void
    {
        $this->freezeTime();

        $this->expectEvents([
            ['product.updated', self::PRODUCT_UPDATE_0],
            ['product.updated', self::PRODUCT_UPDATE_1],
            ['product.updated', self::PRODUCT_UPDATE_2],
            ['product.updated', self::PRODUCT_UPDATE_3],
        ]);

        $category = CategoryContext::create()();
        $productContext = ProductContext::create();
        $user = UserContext::create()();
        $unitContext = UnitContext::create();

        $unit = $unitContext();

        $unitOne = $this->faker->unit('1f5b59bc-0ca0-4f13-9514-500ffbabf990');
        $unitTwo = $this->faker->unit('e0aa6ce2-7761-4f5f-be20-296d7dcf137f');
        $unitThree = $this->faker->unit('567d6d64-9977-449b-856e-03b08e821a55');

        $productContext->units = [
            $unitOne,
            $unitTwo,
            $unitThree,
        ];

        $product = $productContext();

        $this->load($unitOne, $unitTwo, $unitThree, $user, $category, $product, $unit);
        $this->withUser($user);

        $this->assertDatabaseCount( Unit::class, 4);

        $response = $this->sendRequest('PUT', '/api/products', [
                'id' => (string)$product->getId(),
                'name' => (string)$product->getName(),
                'description' => (string)$product->getDescription(),
                'attributes' => [],
                'units' => [
                    (string)$unit->getId(),
                ],
            ]
        );

        $content = (string)$response->getContent();

        self::assertResponseStatusCodeSame(200);
        $this->assertJson($content);

        $body = Json::decode($content);

        $this->assertEquals('1884fcbf-6ade-49a4-b91a-505290ec1e77', $body['id']);
        $this->assertEquals('name', $body['name']);
        $this->assertEquals('description', $body['description']);
        $this->assertCount(0, $body['attributes']);
        $this->assertCount(1, $body['units']);
        $this->assertEquals('14c374a0-e8a9-448c-93e5-fea748240266', $body['units'][0]);
    }

    public function testShouldFailByProductNotFoundError(): void
    {
        $this->freezeTime();

        $this->expectNoEvents();

        $user = UserContext::create()();

        $this->load($user);
        $this->withUser($user);

        $response = $this->sendRequest('PUT', '/api/products', [
                'id' => $this->faker->uuidv4(),
                'name' => 'hello',
                'description' => 'description',
                'attributes' => [],
                'units' => [],
            ]
        );

        $response = (string)$response->getContent();

        self::assertResponseStatusCodeSame(404);
        $this->assertJson($response);

        $content = Json::decode($response);

        $this->assertArrayHasKey('code', $content);
        $this->assertArrayHasKey('message', $content);
        $this->assertEquals(404, $content['code']);
        $this->assertEquals('Product not found', $content['message']);
    }
}

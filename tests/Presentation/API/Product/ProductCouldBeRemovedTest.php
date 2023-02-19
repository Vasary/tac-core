<?php

declare(strict_types=1);

namespace App\Tests\Presentation\API\Product;

use App\Domain\Model\Product;
use App\Infrastructure\Json\Json;
use App\Infrastructure\Test\AbstractWebTestCase;
use App\Infrastructure\Test\Atom\AssertAttributeTrait;
use App\Infrastructure\Test\Atom\AssertEventTrait;
use App\Infrastructure\Test\Context\Model\CategoryContext;
use App\Infrastructure\Test\Context\Model\ProductContext;
use App\Infrastructure\Test\Context\Model\UserContext;

final class ProductCouldBeRemovedTest extends AbstractWebTestCase
{
    use AssertAttributeTrait, AssertEventTrait;

    private const PRODUCT_REMOVED_EVENT = '{"product":{"id":"1884fcbf-6ade-49a4-b91a-505290ec1e77","name":"name","description":"description","creator":"mock|10101011","attributes":[],"category":"6b58caa4-0571-44db-988a-8a75f86b2520","units":[],"createdAt":"2022-01-01T00:00:00+00:00","updatedAt":"2022-01-01T00:00:00+00:00","deletedAt":null}}';

    public function testShouldSuccessfullyRemoveProduct(): void
    {
        $this->freezeTime('2022-09-20 23:00:00');

        $this->expectEvents([
            [
                'product.removed', self::PRODUCT_REMOVED_EVENT
            ]
        ]);

        $user = UserContext::create()();
        $product = ProductContext::create()();
        $category = CategoryContext::create()();

        $this->load($user, $category, $product);
        $this->withUser($user);

        $response = $this->sendRequest('DELETE', '/api/products/' . $product->getId());

        $responseContent = (string)$response->getContent();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJson($responseContent);

        $content = Json::decode($responseContent);

        $this->assertArrayHasKey('status', $content);
        $this->assertArrayHasKey('message', $content);
        $this->assertEquals(200, $content['status']);
        $this->assertEquals('Successfully removed', $content['message']);

        $this->assertDatabaseCount(Product::class, 0);
    }
}

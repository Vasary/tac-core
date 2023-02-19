<?php

declare(strict_types = 1);

namespace App\Tests\Presentation\API\Product;

use App\Domain\Model\Product;
use App\Infrastructure\Json\Json;
use App\Infrastructure\Test\AbstractWebTestCase;
use App\Infrastructure\Test\Atom\AssertAttributeTrait;
use App\Infrastructure\Test\Atom\AssertEventTrait;
use App\Infrastructure\Test\Context\Model\ProductContext;
use App\Infrastructure\Test\Context\Model\UserContext;

final class ProductCouldBeRemovedTest extends AbstractWebTestCase
{
    use AssertAttributeTrait, AssertEventTrait;

    protected static array $ids = [
        '4170f8aa-b4ea-4f6d-b99d-57338808f299',
    ];

    public function testShouldSuccessfullyRemoveProduct(): void
    {
        $this->freezeTime('2022-09-20 23:00:00');

        $user = UserContext::create()();
        $product = ProductContext::create()();

        $this->load($user, $product);
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

<?php

declare(strict_types = 1);

namespace App\Tests\Presentation\API\Product;

use App\Domain\Model\Product;
use App\Domain\Model\User;
use App\Infrastructure\Json\Json;
use App\Infrastructure\Test\AbstractWebTestCase;
use App\Infrastructure\Test\Atom\AssertAttributeTrait;
use App\Infrastructure\Test\Atom\AssertEventTrait;
use App\Infrastructure\Test\Context\Model\CategoryContext;
use App\Infrastructure\Test\Context\Model\ProductContext;
use App\Infrastructure\Test\Context\Model\UserContext;

final class GetProductsListControllerTest extends AbstractWebTestCase
{
    use AssertAttributeTrait, AssertEventTrait;

    public function testShouldSuccessfullyRetrieveProductsList(): void
    {
        $this->assertEvent([]);

        $user = UserContext::create()();
        $category = CategoryContext::create()();

        $this->load($category, $user, $this->generateRandomProduct($user));
        $this->withUser($user);

        $this->browser->jsonRequest('GET', '/api/products?size=1&page=1');

        $responseContent = (string)$this->browser->getResponse()->getContent();

        self::assertResponseStatusCodeSame(200);
        $this->assertJson($responseContent);
        $this->assertDatabaseCount(Product::class, 1);
    }

    public function testShouldSuccessfullyRetrieveProductsListWithTwoProducts(): void
    {
        $this->assertEvent([]);

        $user = UserContext::create()();
        $category = CategoryContext::create()();

        $this->load(
            $user,
            $category,
            $this->generateRandomProduct($user),
            $this->generateRandomProduct($user),
            $this->generateRandomProduct($user),
        );

        $response = $this->send('GET', '/api/products?size=2&page=1');

        $responseContent = (string)$response->getContent();

        self::assertResponseStatusCodeSame(200);
        $this->assertJson($responseContent);

        $content = Json::decode($responseContent);

        $this->assertCount(2, $content['items']);
        $this->assertEquals(3, $content['total']);
        $this->assertDatabaseCount(Product::class, 3);
    }

    private function generateRandomProduct(User $user): Product
    {
        $product = ProductContext::create();
        $product->id = $this->faker->uuidv4();
        $product->name = $this->faker->localization(25);
        $product->description = $this->faker->localization(255);
        $product->user = $user;

        return $product();
    }
}

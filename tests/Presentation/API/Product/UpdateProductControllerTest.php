<?php

declare(strict_types = 1);

namespace App\Tests\Presentation\API\Product;

use App\Infrastructure\Test\AbstractWebTestCase;
use App\Infrastructure\Test\Atom\AssertAttributeTrait;
use App\Infrastructure\Test\Atom\AssertEventTrait;
use App\Infrastructure\Test\Context\Model\CategoryContext;
use App\Infrastructure\Test\Context\Model\ProductContext;
use App\Infrastructure\Test\Context\Model\UserContext;

final class UpdateProductControllerTest extends AbstractWebTestCase
{
    use AssertAttributeTrait, AssertEventTrait;

    public function testShouldNotFailWithNoReasonsToUpdateProduct(): void
    {
        $this->expectNoEvents();

        $categoryContext = CategoryContext::create();
        $productContext = ProductContext::create();
        $userContext = UserContext::create();

        $product = $productContext();
        $category = $categoryContext();

        $this->load($category, $product);
        $this->withUser($userContext());

        $response = $this->sendRequest('PUT', '/api/products', [
                'id' => (string)$product->getId(),
                'name' => (string)$product->getName(),
                'description' => (string)$product->getDescription(),
                'attributes' => [],
                'units' => [],
            ]
        );

        $responseContent = (string)$response->getContent();

        self::assertResponseStatusCodeSame(200);
        $this->assertJson($responseContent);
    }
}

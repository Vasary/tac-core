<?php

declare(strict_types = 1);

namespace App\Tests\Presentation\API\Category;

use App\Infrastructure\Test\AbstractWebTestCase;
use App\Infrastructure\Test\Atom\AssertEventTrait;
use App\Infrastructure\Test\Context\Model\CategoryContext;
use App\Infrastructure\Test\Context\Model\UserContext;

final class GetCategoriesListControllerTest extends AbstractWebTestCase
{
    use AssertEventTrait;

    public function testShouldRetrieveListOfCategories(): void
    {
        $user = UserContext::create()();
        $categoryContext = CategoryContext::create();
        $categoryContext->user = $user;
        $category = $categoryContext();

        $this->load($category);
        $this->withUser($user);

        $response = $this->sendRequest('GET', '/api/category?size=1&page=1');
        $responseContent = (string)$response->getContent();

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(200);
        $this->assertJson($responseContent);

        $decodedContent = json_decode($responseContent, true);

        $this->assertArrayHasKey('items', $decodedContent);
        $this->assertArrayHasKey('total', $decodedContent);
        $this->assertCount(1, $decodedContent['items']);
        $this->assertEquals(1, $decodedContent['total']);
    }
}

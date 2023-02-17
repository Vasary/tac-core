<?php

declare(strict_types = 1);

namespace App\Tests\Presentation\API\Category;

use App\Domain\Model\Category;
use App\Infrastructure\Json\Json;
use App\Infrastructure\Test\AbstractWebTestCase;
use App\Infrastructure\Test\Atom\AssertEventTrait;
use App\Infrastructure\Test\Context\Model\CategoryContext;
use App\Infrastructure\Test\Context\Model\UserContext;

final class GetCategoryControllerTest extends AbstractWebTestCase
{
    use AssertEventTrait;

    public function testShouldRetrieveCategory(): void
    {
        $this->expectEvents();
        $user = UserContext::create()();
        $categoryContext = CategoryContext::create();
        $categoryContext->user = $user;

        $category = $categoryContext();

        $this->load($category);
        $this->withUser($user);

        $response = $this->sendRequest('GET', '/api/category/' . $category->getId());
        $responseContent = (string)$response->getContent();

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(200);
        $this->assertJson($responseContent);

        $decodedContent = json_decode($responseContent, true);

        $this->assertEquals('6b58caa4-0571-44db-988a-8a75f86b2520', $decodedContent['id']);
        $this->assertEquals('mock|10101011', $decodedContent['creator']);
        $this->assertArrayHasKey('id', $decodedContent);
        $this->assertArrayHasKey('name', $decodedContent);
        $this->assertArrayHasKey('creator', $decodedContent);
        $this->assertArrayHasKey('createdAt', $decodedContent);
        $this->assertArrayHasKey('updatedAt', $decodedContent);
        $this->assertArrayHasKey('deletedAt', $decodedContent);
        $this->assertDatabaseCount(Category::class, 1);
    }

    public function testShouldGetNotFoundError(): void
    {
        $this->expectEvents();

        $user = UserContext::create()();

        $this->withUser($user);
        $this->load($user);

        $response = $this->sendRequest('GET', '/api/category/' . $this->faker->uuidv4());

        $responseContent = (string)$response->getContent();
        $decodedContent = Json::decode($responseContent);

        $this->assertResponseStatusCodeSame(404);
        $this->assertJson($responseContent);

        $this->assertArrayHasKey('code', $decodedContent);
        $this->assertArrayHasKey('message', $decodedContent);
        $this->assertEquals(404, $decodedContent['code']);
        $this->assertEquals('Category not found', $decodedContent['message']);
    }
}

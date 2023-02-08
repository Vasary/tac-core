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
        $this->assertEvent();
        $user = UserContext::create()();
        $categoryContext = CategoryContext::create();
        $categoryContext->user = $user;

        $category = $categoryContext();

        $this->load($category);
        $this->withUser($user);

        $this->browser->request('GET', '/api/category/' . $category->getId());

        $responseContent = (string)$this->browser->getResponse()->getContent();

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(200);
        $this->assertJson($responseContent);

        $decodedContent = json_decode($responseContent, true);

        $this->assertEquals('6b58caa4-0571-44db-988a-8a75f86b2520', $decodedContent['id']);
        $this->assertEquals('foo@bar.com', $decodedContent['creator']);
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
        $this->assertEvent();
        $this->withUser(UserContext::create()());

        $this->browser->request('GET', '/api/category/' . $this->faker->uuidv4());

        $responseContent = (string)$this->browser->getResponse()->getContent();
        $decodedContent = Json::decode($responseContent);

        $this->assertResponseStatusCodeSame(404);
        $this->assertJson($responseContent);

        $this->assertArrayHasKey('code', $decodedContent);
        $this->assertArrayHasKey('message', $decodedContent);
        $this->assertEquals(404, $decodedContent['code']);
        $this->assertEquals('Category not found', $decodedContent['message']);
    }
}

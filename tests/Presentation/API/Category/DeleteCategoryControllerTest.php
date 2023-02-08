<?php

declare(strict_types = 1);

namespace App\Tests\Presentation\API\Category;

use App\Domain\Model\Category;
use App\Infrastructure\Json\Json;
use App\Infrastructure\Test\AbstractWebTestCase;
use App\Infrastructure\Test\Atom\AssertEventTrait;
use App\Infrastructure\Test\Context\Model\CategoryContext;
use App\Infrastructure\Test\Context\Model\UserContext;

final class DeleteCategoryControllerTest extends AbstractWebTestCase
{
    use AssertEventTrait;

    private const EVENT_BODY = <<<JSON
{"category":{"id":"6b58caa4-0571-44db-988a-8a75f86b2520","name":"name","creator":"foo@bar.com","createdAt":"2022-01-01T00:00:00+00:00","updatedAt":"2022-01-01T00:00:00+00:00","deletedAt":null}}
JSON;

    public function testShouldSuccessfullyDeleteCategory(): void
    {
        $user = UserContext::create()();
        $categoryContext = CategoryContext::create();
        $categoryContext->user = $user;
        $category = $categoryContext();

        $this->assertEvent([
            ['category.removed', self::EVENT_BODY],
        ]);

        $this->load($category);
        $this->withUser($user);

        $this->browser->request('DELETE', '/api/category/' . $category->getId());

        $responseContent = (string)$this->browser->getResponse()->getContent();

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(200);
        $this->assertJson($responseContent);

        $decodedContent = json_decode($responseContent, true);

        $this->assertDatabaseCount(Category::class, 0);
        $this->assertArrayHasKey('status', $decodedContent);
        $this->assertArrayHasKey('message', $decodedContent);
        $this->assertEquals(200, $decodedContent['status']);
        $this->assertEquals('Successfully removed', $decodedContent['message']);
    }

    public function testShouldGetNotFoundError(): void
    {
        $this->assertEvent();

        $this->load(UserContext::create()());

        $response = $this->send('DELETE', '/api/category/' . $this->faker->uuidv4());

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

<?php

declare(strict_types = 1);

namespace App\Tests\Presentation\API\Category;

use App\Domain\Model\Category;
use App\Domain\Model\Glossary;
use App\Infrastructure\Json\Json;
use App\Infrastructure\Test\AbstractWebTestCase;
use App\Infrastructure\Test\Atom\AssertEventTrait;
use App\Infrastructure\Test\Context\Model\CategoryContext;
use App\Infrastructure\Test\Context\Model\UserContext;

final class UpdateCategoryControllerTest extends AbstractWebTestCase
{
    use AssertEventTrait;

    public function testShouldSuccessfullyUpdateCategory(): void
    {
        $this->freezeTime('2022-10-01T00:00:00+00:00');

        $user = UserContext::create()();
        $categoryContext = CategoryContext::create();
        $categoryContext->user = $user;
        $category = $categoryContext();

        $this->assertEvent([
            ['glossary.updated', '{"glossary":{"objectId":"6b58caa4-0571-44db-988a-8a75f86b2520","field":"name","value":"new name","locale":"en"}}'],
            ['category.updated', '{"category":{"id":"6b58caa4-0571-44db-988a-8a75f86b2520","name":"new name","creator":"foo@bar.com","createdAt":"2022-01-01T00:00:00+00:00","updatedAt":"2022-10-01T00:00:00+00:00","deletedAt":null}}'],
        ]);

        $this->load($category);

        $response = $this->sendJson('PUT', '/api/category', [
            'id' => (string) $category->getId(),
            'name' => 'new name',
        ]);

        $responseContent = (string)$response->getContent();

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(200);
        $this->assertJson($responseContent);

        $content = Json::decode($responseContent);

        $this->assertEquals('6b58caa4-0571-44db-988a-8a75f86b2520', $content['id']);
        $this->assertEquals('new name', $content['name']);
        $this->assertArrayHasKey('creator', $content);
        $this->assertArrayHasKey('createdAt', $content);
        $this->assertArrayHasKey('updatedAt', $content);
        $this->assertArrayHasKey('deletedAt', $content);
        $this->assertNull($content['deletedAt']);
        $this->assertNotEquals($content['createdAt'], $content['updatedAt']);
        $this->assertEquals('2022-10-01T00:00:00+00:00', $content['updatedAt']);
        $this->assertEquals('6b58caa4-0571-44db-988a-8a75f86b2520', $content['id']);

        $this->assertDatabaseCount(Category::class, 1);
        $this->assertDatabaseCount(Glossary::class, 1, useSoftDeleteFilter: false);
    }

    public function testShouldGetNotFoundError(): void
    {
        $this->assertEvent();

        $this->withUser(UserContext::create()());

        $this->browser->jsonRequest('PUT', '/api/category', [
            'id' => $this->faker->uuidv4(),
            'name' => 'new name',
        ]);

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

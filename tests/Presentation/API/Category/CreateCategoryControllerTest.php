<?php

declare(strict_types=1);

namespace App\Tests\Presentation\API\Category;

use App\Domain\Model\Category;
use App\Infrastructure\Test\AbstractWebTestCase;
use App\Infrastructure\Test\Atom\AssertEventTrait;
use App\Infrastructure\Test\Context\Model\UserContext;

final class CreateCategoryControllerTest extends AbstractWebTestCase
{
    use AssertEventTrait;

    protected static array $ids = [
        'b9c0fa48-fd52-4923-b21c-802912da773e',
        '3eb715db-d79e-4db2-ac7a-1862752f3f08',
    ];

    private const GLOSSARY_EVENT = <<<JSON
{"glossary":{"objectId":"b9c0fa48-fd52-4923-b21c-802912da773e","field":"name","value":"green","locale":"en"}}
JSON;

    private const CATEGORY_EVENT = <<<JSON
{"category":{"id":"b9c0fa48-fd52-4923-b21c-802912da773e","name":"green","creator":"foo@bar.com","createdAt":"1986-06-05T00:00:00+00:00","updatedAt":"1986-06-05T00:00:00+00:00","deletedAt":null}}
JSON;

    public function testShouldSuccessfullyCreateNewCategory(): void
    {
        $this->freezeTime('1986-06-05');
        $this->withUser((new UserContext())());

        $this->assertEvent([
            ['glossary.created', self::GLOSSARY_EVENT],
            ['category.created', self::CATEGORY_EVENT],
        ]);

        $this->browser->jsonRequest('POST', '/api/category', [
            'name' => 'green'
        ]);

        $responseContent = (string)$this->browser->getResponse()->getContent();

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(201);
        $this->assertJson($responseContent);

        $decodedContent = json_decode($responseContent, true);

        $this->assertEquals('green', $decodedContent['name']);
        $this->assertEquals('foo@bar.com', $decodedContent['creator']);
        $this->assertArrayHasKey('id', $decodedContent);
        $this->assertArrayHasKey('name', $decodedContent);
        $this->assertArrayHasKey('creator', $decodedContent);
        $this->assertArrayHasKey('createdAt', $decodedContent);
        $this->assertArrayHasKey('updatedAt', $decodedContent);
        $this->assertArrayHasKey('deletedAt', $decodedContent);
        $this->assertDatabaseCount(Category::class, 1);
        $this->assertEquals('b9c0fa48-fd52-4923-b21c-802912da773e', $decodedContent['id']);
        $this->assertEquals($decodedContent['createdAt'], $decodedContent['updatedAt']);
        $this->assertEquals('1986-06-05T00:00:00+00:00', $decodedContent['createdAt']);
    }
}

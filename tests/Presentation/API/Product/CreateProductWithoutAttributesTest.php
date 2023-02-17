<?php

declare(strict_types = 1);

namespace App\Tests\Presentation\API\Product;

use App\Infrastructure\Test\AbstractWebTestCase;
use App\Infrastructure\Test\Atom\AssertAttributeTrait;
use App\Infrastructure\Test\Atom\AssertEventTrait;
use App\Infrastructure\Test\Context\Model\CategoryContext;
use App\Infrastructure\Test\Context\Model\UserContext;

final class CreateProductWithoutAttributesTest extends AbstractWebTestCase
{
    use AssertAttributeTrait, AssertEventTrait;

    private const GLOSSARY_NAME = <<<JSON
{"glossary":{"objectId":"b5bd3baf-c77e-45e6-93b4-93a642b015de","field":"name","value":"Monitor","locale":"en"}}
JSON;

    private const GLOSSARY_DESCRIPTION = <<<JSON
{"glossary":{"objectId":"b5bd3baf-c77e-45e6-93b4-93a642b015de","field":"description","value":"There is a simple nice monitor","locale":"en"}}
JSON;

    private const PRODUCT = <<<JSON
{"product":{"id":"b5bd3baf-c77e-45e6-93b4-93a642b015de","name":"Monitor","description":"There is a simple nice monitor","creator":"mock|10101011","attributes":[],"category":"6b58caa4-0571-44db-988a-8a75f86b2520","units":[],"createdAt":"2022-09-01T00:00:00+00:00","updatedAt":"2022-09-01T00:00:00+00:00","deletedAt":null}}
JSON;

    protected static array $ids = [
        'b5bd3baf-c77e-45e6-93b4-93a642b015de',
        '62839033-ada2-4257-8dba-a9bf036961e8',
        '178aa1b0-021d-41a6-8430-314f32b0127e',
    ];

    public function testShouldSuccessfullyCreateProductWithoutAttributes(): void
    {
        $this->freezeTime();

        $this->expectEvents([
            ['glossary.created', self::GLOSSARY_NAME],
            ['glossary.created', self::GLOSSARY_DESCRIPTION],
            ['product.created', self::PRODUCT],
        ]);

        $user = UserContext::create()();

        $categoryContext = CategoryContext::create();
        $categoryContext->user = $user;
        $category = $categoryContext();

        $this->load($user, $category);

        $this->withUser($user);
        $response = $this->sendRequest('POST', '/api/products', [
            'name' => 'Monitor',
            'description' => 'There is a simple nice monitor',
            'category' => (string)$category->getId(),
            'attributes' => [],
            'units' => [],
        ]);

        $responseContent = (string)$response->getContent();

        self::assertResponseStatusCodeSame(201);
        $this->assertJson($responseContent);

        $content = json_decode($responseContent, true);

        $this->assertEquals('Monitor', $content['name']);
        $this->assertEquals('There is a simple nice monitor', $content['description']);
        $this->assertIsArray($content['attributes']);
        $this->assertCount(0, $content['attributes']);
        $this->assertIsArray($content['units']);
        $this->assertCount(0, $content['units']);
        $this->assertEquals('mock|10101011', $content['creator']);
        $this->assertArrayHasKey('createdAt', $content);
        $this->assertArrayHasKey('updatedAt', $content);
        $this->assertArrayHasKey('id', $content);
        $this->assertNull($content['deletedAt']);
        $this->assertEquals('2022-09-01T00:00:00+00:00', $content['createdAt']);
        $this->assertEquals('2022-09-01T00:00:00+00:00', $content['updatedAt']);
    }

    public function testShouldSuccessfullyCreateProductWithoutAttributesAndUnitsData(): void
    {
        $this->freezeTime();

        $this->expectEvents([
            ['glossary.created', self::GLOSSARY_NAME],
            ['glossary.created', self::GLOSSARY_DESCRIPTION],
            ['product.created', self::PRODUCT],
        ]);

        $user = UserContext::create()();

        $categoryContext = CategoryContext::create();
        $categoryContext->user = $user;
        $category = $categoryContext();

        $this->load($user, $category);

        $this->withUser($user);
        $response = $this->sendRequest('POST', '/api/products', [
            'name' => 'Monitor',
            'description' => 'There is a simple nice monitor',
            'category' => (string)$category->getId(),
        ]);

        $responseContent = (string)$response->getContent();

        self::assertResponseStatusCodeSame(201);
        $this->assertJson($responseContent);

        $content = json_decode($responseContent, true);

        $this->assertEquals('Monitor', $content['name']);
        $this->assertEquals('There is a simple nice monitor', $content['description']);
        $this->assertEquals('There is a simple nice monitor', $content['description']);
        $this->assertIsArray($content['attributes']);
        $this->assertCount(0, $content['attributes']);
        $this->assertIsArray($content['units']);
        $this->assertCount(0, $content['units']);
        $this->assertEquals('mock|10101011', $content['creator']);
        $this->assertArrayHasKey('createdAt', $content);
        $this->assertArrayHasKey('updatedAt', $content);
        $this->assertArrayHasKey('id', $content);
        $this->assertNull($content['deletedAt']);
        $this->assertEquals('2022-09-01T00:00:00+00:00', $content['createdAt']);
        $this->assertEquals('2022-09-01T00:00:00+00:00', $content['updatedAt']);
    }
}

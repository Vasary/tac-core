<?php

declare(strict_types = 1);

namespace App\Tests\Presentation\API\Product;

use App\Infrastructure\Json\Json;
use App\Infrastructure\Test\AbstractWebTestCase;
use App\Infrastructure\Test\Atom\AssertAttributeTrait;
use App\Infrastructure\Test\Atom\AssertEventTrait;
use App\Infrastructure\Test\Context\Model\AttributeContext;
use App\Infrastructure\Test\Context\Model\AttributeValueContext;
use App\Infrastructure\Test\Context\Model\CategoryContext;
use App\Infrastructure\Test\Context\Model\ProductContext;
use App\Infrastructure\Test\Context\Model\UserContext;

final class UpdateProductRemoveOutdatedAttributeValuesTest extends AbstractWebTestCase
{
    use AssertAttributeTrait, AssertEventTrait;

    private const PRODUCT_EVENT_0 = <<<JSON
{"product":{"id":"1884fcbf-6ade-49a4-b91a-505290ec1e77","name":"name","description":"description","creator":"foo@bar.com","attributes":[{"id":"80df2e33-6bad-4f91-9208-e938b543e31c","attribute":{"id":"8f91fbc8-292c-4594-9ed2-d67f769976c7","code":"name","type":"string","name":"name","description":"description","value":"A mock value"},"parent":"","creator":"foo@bar.com","createdAt":"2022-01-01T00:00:00+00:00","updatedAt":"2022-09-01T00:00:00+00:00","deletedAt":null},{"id":"8a730673-0740-46d2-956e-505908ff140e","attribute":{"id":"4e897f97-dc43-4de3-bb16-358943bac606","code":"surname","type":"string","name":"name","description":"description","value":"Doe"},"parent":"","creator":"foo@bar.com","createdAt":"2022-09-01T00:00:00+00:00","updatedAt":"2022-09-01T00:00:00+00:00","deletedAt":null}],"category":"6b58caa4-0571-44db-988a-8a75f86b2520","units":[],"createdAt":"2022-01-01T00:00:00+00:00","updatedAt":"2022-09-01T00:00:00+00:00","deletedAt":null}}
JSON;

    private const PRODUCT_EVENT_1 = <<<JSON
{"product":{"id":"1884fcbf-6ade-49a4-b91a-505290ec1e77","name":"name","description":"description","creator":"foo@bar.com","attributes":[{"id":"80df2e33-6bad-4f91-9208-e938b543e31c","attribute":{"id":"8f91fbc8-292c-4594-9ed2-d67f769976c7","code":"name","type":"string","name":"name","description":"description","value":"A mock value"},"parent":"","creator":"foo@bar.com","createdAt":"2022-01-01T00:00:00+00:00","updatedAt":"2022-09-01T00:00:00+00:00","deletedAt":null},{"id":"8a730673-0740-46d2-956e-505908ff140e","attribute":{"id":"4e897f97-dc43-4de3-bb16-358943bac606","code":"surname","type":"string","name":"name","description":"description","value":"Doe"},"parent":"","creator":"foo@bar.com","createdAt":"2022-09-01T00:00:00+00:00","updatedAt":"2022-09-01T00:00:00+00:00","deletedAt":null}],"category":"6b58caa4-0571-44db-988a-8a75f86b2520","units":[],"createdAt":"2022-01-01T00:00:00+00:00","updatedAt":"2022-09-01T00:00:00+00:00","deletedAt":null}}
JSON;

    private const ATTRIBUTE_VALUE_EVENT_0 = <<<JSON
{"attributeValue":{"id":"80df2e33-6bad-4f91-9208-e938b543e31c","attribute":{"id":"8f91fbc8-292c-4594-9ed2-d67f769976c7","code":"name","type":"string","name":"name","description":"description","value":"A mock value"},"parent":"","creator":"foo@bar.com","createdAt":"2022-01-01T00:00:00+00:00","updatedAt":"2022-09-01T00:00:00+00:00","deletedAt":null}}
JSON;

    private const ATTRIBUTE_VALUE_EVENT_1 = <<<JSON
{"attributeValue":{"id":"80df2e33-6bad-4f91-9208-e938b543e31c","attribute":{"id":"8f91fbc8-292c-4594-9ed2-d67f769976c7","code":"name","type":"string","name":"name","description":"description","value":"A mock value"},"parent":"","creator":"foo@bar.com","createdAt":"2022-01-01T00:00:00+00:00","updatedAt":"2022-09-01T00:00:00+00:00","deletedAt":null}}
JSON;

    private const ATTRIBUTE_VALUE_EVENT_2 = <<<JSON
{"attributeValue":{"id":"8a730673-0740-46d2-956e-505908ff140e","attribute":{"id":"4e897f97-dc43-4de3-bb16-358943bac606","code":"surname","type":"string","name":"name","description":"description","value":"Doe"},"parent":"","creator":"foo@bar.com","createdAt":"2022-09-01T00:00:00+00:00","updatedAt":"2022-09-01T00:00:00+00:00","deletedAt":null}}
JSON;

    private const ATTRIBUTE_VALUE_REMOVED_0 = <<<JSON
{"attributeValue":{"id":"a21c4e4d-fd4f-458b-9dde-8e6eba30db79","attribute":{"id":"208f51b8-fdcc-4611-bb44-8c0975bdbf80","code":"family","type":"string","name":"name","description":"description","value":null},"parent":"","creator":"foo@bar.com","createdAt":"2022-01-01T00:00:00+00:00","updatedAt":"2022-01-01T00:00:00+00:00","deletedAt":null}}
JSON;

    private const ATTRIBUTE_VALUE_CREATED = <<<JSON
{"attributeValue":{"id":"8a730673-0740-46d2-956e-505908ff140e","attribute":{"id":"4e897f97-dc43-4de3-bb16-358943bac606","code":"surname","type":"string","name":"name","description":"description","value":"Doe"},"parent":"","creator":"foo@bar.com","createdAt":"2022-09-01T00:00:00+00:00","updatedAt":"2022-09-01T00:00:00+00:00","deletedAt":null}}
JSON;

    protected static array $ids = [
        '8a730673-0740-46d2-956e-505908ff140e',
    ];

    public function testShouldSuccessfullyUpdateProductAttributesList(): void
    {
        $this->freezeTime();

        $this->assertEvent([
            ['product.updated', self::PRODUCT_EVENT_0],
            ['product.updated', self::PRODUCT_EVENT_1],
            ['attribute.value.updated', self::ATTRIBUTE_VALUE_EVENT_0],
            ['attribute.value.updated', self::ATTRIBUTE_VALUE_EVENT_1],
            ['attribute.value.updated', self::ATTRIBUTE_VALUE_EVENT_2],
            ['attribute.value.removed', self::ATTRIBUTE_VALUE_REMOVED_0],
            ['attribute.value.created', self::ATTRIBUTE_VALUE_CREATED],
        ]);

        $category = CategoryContext::create()();
        $user = UserContext::create()();
        $product = ProductContext::create()();

        $firstAttributeContext = AttributeContext::create();
        $firstAttributeContext->id = '8f91fbc8-292c-4594-9ed2-d67f769976c7';
        $firstAttributeContext->code = 'name';

        $secondAttributeContext = AttributeContext::create();
        $secondAttributeContext->id = '4e897f97-dc43-4de3-bb16-358943bac606';
        $secondAttributeContext->code = 'surname';

        $thirdAttributeContext = AttributeContext::create();
        $thirdAttributeContext->id = '208f51b8-fdcc-4611-bb44-8c0975bdbf80';
        $thirdAttributeContext->code = 'family';

        $firstAttribute = $firstAttributeContext();
        $secondAttribute = $secondAttributeContext();
        $thirdAttribute = $thirdAttributeContext();

        $firstAttributeValueContext = AttributeValueContext::create();
        $firstAttributeValueContext->id = '80df2e33-6bad-4f91-9208-e938b543e31c';
        $firstAttributeValueContext->attribute = $firstAttribute;
        $firstAttributeValueContext->product = $product;
        $firstAttributeValue = $firstAttributeValueContext();

        $thirdAttributeValueContext = AttributeValueContext::create();
        $thirdAttributeValueContext->id = 'a21c4e4d-fd4f-458b-9dde-8e6eba30db79';
        $thirdAttributeValueContext->attribute = $thirdAttribute;
        $thirdAttributeValueContext->product = $product;
        $thirdAttributeValue = $thirdAttributeValueContext();

        $this->load(
            $user,
            $category,
            $product,
            $firstAttribute,
            $secondAttribute,
            $thirdAttribute,
            $firstAttributeValue,
            $thirdAttributeValue,
        );

        $response = $this->sendJson('PUT', '/api/products', [
                'id' => (string)$product->getId(),
                'name' => $product->getName()->value(),
                'description' => $product->getDescription()->value(),
                'attributes' => [
                    [
                        'id' => '8f91fbc8-292c-4594-9ed2-d67f769976c7',
                        'value' => 'A mock value',
                    ],
                    [
                        'id' => '4e897f97-dc43-4de3-bb16-358943bac606',
                        'value' => 'Doe',
                    ],
                ],
                'units' => [],
            ]
        );

        $content = (string)$response->getContent();

        self::assertResponseStatusCodeSame(200);
        $this->assertJson($content);

        $body = Json::decode($content);

        $this->assertCount(2, $body['attributes']);
        $this->assertAttributeValue($body['attributes'][0]);
        $this->assertAttributeValue($body['attributes'][1]);

        $this->assertEquals('A mock value', $body['attributes'][0]['attribute']['value']);
        $this->assertEquals('description', $body['attributes'][0]['attribute']['description']);
        $this->assertEquals('name', $body['attributes'][0]['attribute']['name']);
        $this->assertEquals('name', $body['attributes'][0]['attribute']['code']);
        $this->assertEquals('string', $body['attributes'][0]['attribute']['type']);
        $this->assertEquals('80df2e33-6bad-4f91-9208-e938b543e31c', $body['attributes'][0]['id']);

        $this->assertEquals('Doe', $body['attributes'][1]['attribute']['value']);
        $this->assertEquals('description', $body['attributes'][1]['attribute']['description']);
        $this->assertEquals('name', $body['attributes'][1]['attribute']['name']);
        $this->assertEquals('surname', $body['attributes'][1]['attribute']['code']);
        $this->assertEquals('string', $body['attributes'][1]['attribute']['type']);
        $this->assertEquals('8a730673-0740-46d2-956e-505908ff140e', $body['attributes'][1]['id']);
    }
}

<?php

declare(strict_types = 1);

namespace App\Tests\Presentation\API\Product;

use App\Domain\Model\Attribute\Type\ArrayType;
use App\Domain\Model\Attribute\Type\BooleanType;
use App\Domain\ValueObject\I18N;
use App\Infrastructure\Json\Json;
use App\Infrastructure\Test\AbstractWebTestCase;
use App\Infrastructure\Test\Atom\AssertAttributeTrait;
use App\Infrastructure\Test\Atom\AssertEventTrait;
use App\Infrastructure\Test\Context\Model\AttributeContext;
use App\Infrastructure\Test\Context\Model\AttributeValueContext;
use App\Infrastructure\Test\Context\Model\CategoryContext;
use App\Infrastructure\Test\Context\Model\ProductContext;
use App\Infrastructure\Test\Context\Model\UserContext;

final class MoveAttributeFromArrayToTopLevelTest extends AbstractWebTestCase
{
    use AssertAttributeTrait, AssertEventTrait;

    private const ATTRIBUTE_VALUE_UPDATE_EVENT = <<<JSON
{"attributeValue":{"id":"74bd275f-b4df-439a-a1f5-c15113a7f724","attribute":{"id":"6323609e-d9da-4d4d-bde0-d101edb0d51b","code":"wireless","type":"boolean","name":"name","description":"description","value":true},"parent":"","creator":"mock|10101011","createdAt":"2022-01-01T00:00:00+00:00","updatedAt":"2022-09-01T00:00:00+00:00","deletedAt":null}}
JSON;

    public function testShouldSuccessfullyModifyProductAttributeAndMoveItNoTopLevelFromArray(): void
    {
        $this->freezeTime();

        $this->expectEvents([
            ['attribute.value.updated', self::ATTRIBUTE_VALUE_UPDATE_EVENT],
        ]);

        $user = UserContext::create()();

        $attributeConnectivityContext = AttributeContext::create();
        $attributeConnectivityContext->id = '7a5b0941-43b6-41f7-baff-ad39432abb67';
        $attributeConnectivityContext->type = new ArrayType();
        $attributeConnectivityContext->code = 'connectivity';
        $attributeConnectivity = $attributeConnectivityContext();

        $attributePortContext = AttributeContext::create();
        $attributePortContext->id = 'fee8f295-7b19-4d94-8245-1690ab054ad7';
        $attributePortContext->type = new BooleanType();
        $attributePortContext->code = 'port';
        $attributePort = $attributePortContext();

        $attributeWirelessContext = AttributeContext::create();
        $attributeWirelessContext->id = '6323609e-d9da-4d4d-bde0-d101edb0d51b';
        $attributeWirelessContext->type = new BooleanType();
        $attributeWirelessContext->code = 'wireless';
        $attributeWireless = $attributeWirelessContext();

        $categoryContext = CategoryContext::create();
        $categoryContext->name = new I18N('Category name');
        $category = $categoryContext();

        $productContext = ProductContext::create();
        $product = $productContext();

        $arrayAttributeValueContext = AttributeValueContext::create();
        $arrayAttributeValueContext->id = '05a78e56-be86-4c04-b400-999758453ffa';
        $arrayAttributeValueContext->value = null;
        $arrayAttributeValueContext->attribute = $attributeConnectivity;
        $arrayAttributeValueContext->product = $product;
        $arrayAttributeValue = $arrayAttributeValueContext();

        $portAttributeValueContext = AttributeValueContext::create();
        $portAttributeValueContext->id = '5d783188-a635-44ff-a5aa-bb2cb532cfa1';
        $portAttributeValueContext->value = 'true';
        $portAttributeValueContext->attribute = $attributePort;
        $portAttributeValueContext->parent = $arrayAttributeValue->getAttribute()->getId();
        $portAttributeValueContext->product = $product;
        $portAttributeValue = $portAttributeValueContext();

        $wirelessAttributeValueContext = AttributeValueContext::create();
        $wirelessAttributeValueContext->id = '74bd275f-b4df-439a-a1f5-c15113a7f724';
        $wirelessAttributeValueContext->value = 'true';
        $wirelessAttributeValueContext->attribute = $attributeWireless;
        $wirelessAttributeValueContext->parent = $arrayAttributeValue->getAttribute()->getId();
        $wirelessAttributeValueContext->product = $product;
        $wirelessAttributeValue = $wirelessAttributeValueContext();

        $this->load(
            $user,
            $category,
            $product,
            $attributePort,
            $attributeConnectivity,
            $attributeWireless,
            $portAttributeValue,
            $wirelessAttributeValue,
            $arrayAttributeValue,
        );

        $this->withUser($user);

        $response = $this->sendRequest('PUT', '/api/products', [
            'id' => (string)$product->getId(),
            'name' => $product->getName()->value(),
            'description' => $product->getDescription()->value(),
            'category' => (string)$category->getId(),
            'units' => [],
            'attributes' => [
                [
                    'id' => '7a5b0941-43b6-41f7-baff-ad39432abb67',
                    'value' => [
                        [
                            'id' => 'fee8f295-7b19-4d94-8245-1690ab054ad7',
                            'value' => 'true',
                        ],
                    ],
                ],
                [
                    'id' => '6323609e-d9da-4d4d-bde0-d101edb0d51b',
                    'value' => 'true',
                ],
            ],
        ]);

        $responseContent = (string)$response->getContent();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJson($responseContent);

        $content = Json::decode($responseContent);

        $this->assertCount(3,$content['attributes']);

        $this->assertEquals('7a5b0941-43b6-41f7-baff-ad39432abb67', $content['attributes'][0]['parent']);
        $this->assertEmpty($content['attributes'][1]['parent']);
    }
}

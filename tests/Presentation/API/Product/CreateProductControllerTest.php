<?php

declare(strict_types = 1);

namespace App\Tests\Presentation\API\Product;

use App\Domain\Model\Attribute\Type\ArrayType;
use App\Domain\Model\Attribute\Type\BooleanType;
use App\Domain\Model\Attribute\Type\IntegerType;
use App\Domain\ValueObject\I18N;
use App\Infrastructure\Test\AbstractWebTestCase;
use App\Infrastructure\Test\Atom\AssertAttributeTrait;
use App\Infrastructure\Test\Atom\AssertEventTrait;
use App\Infrastructure\Test\Context\Model\AttributeContext;
use App\Infrastructure\Test\Context\Model\CategoryContext;
use App\Infrastructure\Test\Context\Model\UnitContext;
use App\Infrastructure\Test\Context\Model\UserContext;

final class CreateProductControllerTest extends AbstractWebTestCase
{
    use AssertAttributeTrait, AssertEventTrait;

    protected static array $ids = [
        'af3de651-754b-4dbe-89ee-ca6cbb7549f0',
        '20e90cb7-0f31-4804-bb42-9122e0d670e8',
        'a36e9f12-725a-4ed6-b2cb-0321d529ea66',
        'ee69915a-5a4a-4399-aa28-4322da2f2c9b',
        'c532b5e2-3eb4-4b60-9dd6-4797f7642305',
        '05462bb0-444d-4101-9a94-d607724b3047',
        'a0e48991-64c5-4e2d-9c33-c2e9d5150bcc',
        'f5812d3c-c6a2-49be-b02d-c1786c93c023',
        '2560f92f-5257-4b43-a5be-bc89036deb34',
        '2ef9ee43-898f-4004-a312-56571eeb010b',
        '052b3595-08c2-4d62-a3e0-7f461485051b',
        '687da674-19b0-41bf-a20b-09338c3de534',
    ];

    public function testShouldSuccessfullyCreateProductWithAttributes(): void
    {
        $this->freezeTime();
        $this->expectEvents([
            ['attribute.value.created', CreateProductObject::ATTRIBUTE_VALUE_CREATED_0],
            ['attribute.value.updated', CreateProductObject::ATTRIBUTE_VALUE_UPDATED_0],

            ['attribute.value.created', CreateProductObject::ATTRIBUTE_VALUE_CREATED_1],
            ['attribute.value.updated', CreateProductObject::ATTRIBUTE_VALUE_UPDATED_1],

            ['attribute.value.created', CreateProductObject::ATTRIBUTE_VALUE_CREATED_2],
            ['attribute.value.updated', CreateProductObject::ATTRIBUTE_VALUE_UPDATED_2],

            ['attribute.value.created', CreateProductObject::ATTRIBUTE_VALUE_CREATED_3],
            ['attribute.value.updated', CreateProductObject::ATTRIBUTE_VALUE_UPDATED_3],

            ['attribute.value.created', CreateProductObject::ATTRIBUTE_VALUE_CREATED_4],
            ['attribute.value.updated', CreateProductObject::ATTRIBUTE_VALUE_UPDATED_4],

            ['attribute.value.created', CreateProductObject::ATTRIBUTE_VALUE_CREATED_5],
            ['attribute.value.updated', CreateProductObject::ATTRIBUTE_VALUE_UPDATED_5],

            ['attribute.value.created', CreateProductObject::ATTRIBUTE_VALUE_CREATED_6],
            ['attribute.value.updated', CreateProductObject::ATTRIBUTE_VALUE_UPDATED_6],

            ['attribute.value.created', CreateProductObject::ATTRIBUTE_VALUE_CREATED_7],
            ['attribute.value.updated', CreateProductObject::ATTRIBUTE_VALUE_UPDATED_7],

            ['attribute.value.created', CreateProductObject::ATTRIBUTE_VALUE_CREATED_8],
            ['attribute.value.updated', CreateProductObject::ATTRIBUTE_VALUE_UPDATED_8],

            ['product.created', CreateProductObject::PRODUCT],
            ['product.updated', CreateProductObject::PRODUCT_UPDATE_0],
            ['product.updated', CreateProductObject::PRODUCT_UPDATE_1],

            ['glossary.created', CreateProductObject::GLOSSARY_NAME],
            ['glossary.created', CreateProductObject::GLOSSARY_DESCRIPTION],
        ]);

        $category = CategoryContext::create()();

        $attributeColorContext = AttributeContext::create();
        $attributeColorContext->id = 'cd684b54-632f-48c2-a630-c08d70526234';
        $attributeColorContext->code = 'color';

        $attributeManufacturerContext = AttributeContext::create();
        $attributeManufacturerContext->id = 'a794af18-7542-400c-8c22-740bf5b0620e';
        $attributeManufacturerContext->code = 'manufacturer';

        $attributeDviContext = AttributeContext::create();
        $attributeDviContext->id = 'fee8f295-7b19-4d94-8245-1690ab054ad7';
        $attributeDviContext->code = 'dvi';

        $attributeHDMIContext = AttributeContext::create();
        $attributeHDMIContext->id = 'ed7257c6-50c1-499b-8900-b46d254a51ff';
        $attributeHDMIContext->code = 'hdmi';
        $attributeHDMIContext->type = new BooleanType();

        $attributeUSBContext = AttributeContext::create();
        $attributeUSBContext->id = 'fa9c421a-dcb1-4e97-becd-c19e11d31c0c';
        $attributeUSBContext->code = 'usb';
        $attributeUSBContext->type = new BooleanType();

        $attributeConnectivityContext = AttributeContext::create();
        $attributeConnectivityContext->id = '7a5b0941-43b6-41f7-baff-ad39432abb67';
        $attributeConnectivityContext->type = new ArrayType();
        $attributeConnectivityContext->code = 'connectivity';

        $attributeYearContext = AttributeContext::create();
        $attributeYearContext->id = '829636fe-62cc-4349-9246-de9fa94778d5';
        $attributeYearContext->type = new IntegerType();
        $attributeYearContext->code = 'year';

        $attributeSaleContext = AttributeContext::create();
        $attributeSaleContext->id = '6323609e-d9da-4d4d-bde0-d101edb0d51b';
        $attributeSaleContext->type = new BooleanType();
        $attributeSaleContext->code = 'sale';

        $attributeRecommendationContext = AttributeContext::create();
        $attributeRecommendationContext->id = '9d0b79cb-d621-4de6-98dd-0d08000533a8';
        $attributeRecommendationContext->type = new BooleanType();
        $attributeRecommendationContext->code = 'recommendation';

        $firstUnitContext = UnitContext::create();
        $firstUnitContext->id = '821fffe8-34d2-4cc4-81e8-089bfc7ad77a';
        $firstUnitContext->name = new I18N('Kilogram');
        $firstUnitContext->alias = new I18N('KG');
        $unitOne = $firstUnitContext();

        $secondUnitContext = UnitContext::create();
        $secondUnitContext->id = '1af0f0b6-ad6a-4315-ae4d-18e5d587865a';
        $secondUnitContext->name = new I18N('Liters');
        $secondUnitContext->alias = new I18N('L');
        $unitTwo = $secondUnitContext();

        $user = UserContext::create()();

        $this->load(
            $user,
            $attributeColorContext(),
            $attributeManufacturerContext(),
            $attributeDviContext(),
            $attributeHDMIContext(),
            $attributeUSBContext(),
            $attributeConnectivityContext(),
            $attributeYearContext(),
            $attributeSaleContext(),
            $attributeRecommendationContext(),
            $category,
            $unitOne,
            $unitTwo,
        );

        $this->withUser($user);

        $response = $this->sendRequest('POST', '/api/products', [
            'name' => 'Monitor',
            'description' => 'There is a simple nice monitor',
            'category' => (string)$category->getId(),
            'units' => [
                (string)$unitOne->getId(),
                (string)$unitTwo->getId(),
            ],
            'attributes' => [
                [
                    'id' => 'cd684b54-632f-48c2-a630-c08d70526234',
                    'value' => 'black',
                ],
                [
                    'id' => '7a5b0941-43b6-41f7-baff-ad39432abb67',
                    'value' => [
                        [
                            'id' => 'fee8f295-7b19-4d94-8245-1690ab054ad7',
                            'value' => 'true',
                        ],
                        [
                            'id' => 'ed7257c6-50c1-499b-8900-b46d254a51ff',
                            'value' => 'true',
                        ],
                        [
                            'id' => 'fa9c421a-dcb1-4e97-becd-c19e11d31c0c',
                            'value' => 'false',
                        ],
                    ],
                ],
                [
                    'id' => '829636fe-62cc-4349-9246-de9fa94778d5',
                    'value' => 2022,
                ],
                [
                    'id' => 'a794af18-7542-400c-8c22-740bf5b0620e',
                    'value' => 'LG',
                ],
                [
                    'id' => '6323609e-d9da-4d4d-bde0-d101edb0d51b',
                    'value' => false,
                ],
                [
                    'id' => '9d0b79cb-d621-4de6-98dd-0d08000533a8',
                    'value' => true,
                ],
            ],
        ]);

        $responseContent = (string)$response->getContent();

        self::assertResponseStatusCodeSame(201);
        $this->assertJson($responseContent);

        $content = json_decode($responseContent, true);

        $this->assertEquals('Monitor', $content['name']);
        $this->assertEquals('There is a simple nice monitor', $content['description']);
        $this->assertArrayHasKey('id', $content);
        $this->assertArrayHasKey('creator', $content);
        $this->assertArrayHasKey('creator', $content);
        $this->assertArrayHasKey('createdAt', $content);
        $this->assertArrayHasKey('updatedAt', $content);
        $this->assertArrayHasKey('deletedAt', $content);
        $this->assertArrayHasKey('attributes', $content);
        $this->assertArrayHasKey('units', $content);
        $this->assertIsArray($content['attributes']);
        $this->assertIsArray($content['units']);
        $this->assertCount(9, $content['attributes']);
        $this->assertCount(2, $content['units']);
        $this->assertEquals('821fffe8-34d2-4cc4-81e8-089bfc7ad77a', $content['units'][0]);
        $this->assertEquals('1af0f0b6-ad6a-4315-ae4d-18e5d587865a', $content['units'][1]);
        $this->assertEquals('2022-09-01T00:00:00+00:00', $content['createdAt']);
        $this->assertEquals('2022-09-01T00:00:00+00:00', $content['updatedAt']);

        $this->assertAttributeValueInCollection('color', 'black', $content['attributes']);
        $this->assertAttributeValueInCollection('dvi', true, $content['attributes']);
        $this->assertAttributeValueInCollection('hdmi', true, $content['attributes']);
        $this->assertAttributeValueInCollection('usb', false, $content['attributes']);
        $this->assertAttributeValueInCollection('year', 2022, $content['attributes']);
        $this->assertAttributeValueInCollection('manufacturer', 'LG', $content['attributes']);
        $this->assertAttributeValueInCollection('connectivity', null, $content['attributes']);
        $this->assertAttributeValueInCollection('sale', false, $content['attributes']);
        $this->assertAttributeValueInCollection('recommendation', true, $content['attributes']);
    }
}

<?php

declare(strict_types=1);

namespace App\Infrastructure\OpenAPI\Product;

use App\Infrastructure\Map\ParametersList;
use Attribute;
use OpenApi\Attributes as OA;

#[Attribute(Attribute::IS_REPEATABLE | Attribute::TARGET_CLASS | Attribute::TARGET_METHOD)]
final class UpdateRequest extends OA\RequestBody
{
    public function __construct()
    {
        parent::__construct(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(
                        property: ParametersList::ID,
                        description: 'Product id',
                        type: 'string',
                        example: '645163ef-f3c8-4653-8d82-ae82c59959c8'
                    ),
                    new OA\Property(
                        property: ParametersList::NAME,
                        description: 'Product name',
                        type: 'string',
                        example: 'Potato'
                    ),
                    new OA\Property(
                        property: ParametersList::DESCRIPTION,
                        description: 'Product description',
                        type: 'string',
                        example: 'The potato is a starchy food, a tuber of the plant.'
                    ),
                    new OA\Property(
                        property: ParametersList::CATEGORY,
                        description: 'Product category id',
                        type: 'string',
                        example: '5bbdd66e-c60d-495d-8f68-23455c7ad022'
                    ),
                    new OA\Property(
                        property: ParametersList::UNITS,
                        description: 'Array of supported units',
                        type: 'array',
                        items: new OA\Items(
                            type: 'string',
                            example: ['1400e1eb-8f67-4a64-9eae-20aca1aaed80']
                        )
                    ),
                    new OA\Property(
                        property: ParametersList::ATTRIBUTES,
                        description: 'Array of supported units',
                        type: 'array',
                        items: new OA\Items(
                            oneOf: [new ProductAttributeSchema()]
                        )
                    ),
                ]
            )
        );
    }
}

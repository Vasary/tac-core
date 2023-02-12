<?php

declare(strict_types = 1);

namespace App\Infrastructure\OpenAPI\Product;

use App\Infrastructure\Map\ParametersList;
use OpenApi\Attributes as OA;

final class ProductSchema extends OA\Schema
{
    public function __construct()
    {
        parent::__construct(
            properties: [
                new OA\Property(
                    property: ParametersList::ID,
                    description: 'Product id',
                    type: 'string',
                    example: 'd73f21d1-5313-4d49-9695-920d5b812997',
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
                    example: 'This is my favourite food',
                ),
                new OA\Property(
                    property: ParametersList::CREATOR,
                    description: 'Creator',
                    type: 'string',
                    example: 'facebook|101010',
                ),
                new OA\Property(
                    property: ParametersList::CATEGORY,
                    description: 'Product category id',
                    type: 'string',
                    example: '14b97680-7e8d-47aa-a19b-b020eed37e3b',
                ),
                new OA\Property(
                    property: ParametersList::UNITS,
                    description: 'Product units',
                    type: 'array',
                    items: new OA\Items(
                        type: 'string',
                        example: ['6ffbe34d-5aaf-4392-843c-9e1595790e88']
                    )
                ),
                new OA\Property(
                    property: ParametersList::ATTRIBUTES,
                    description: 'Product attributes',
                    type: 'array',
                    items: new OA\Items(
                        type: 'object',
                        oneOf: [new AttributeValueSchema()]
                    )
                ),
                new OA\Property(
                    property: ParametersList::CREATED_AT,
                    description: 'Product was created at',
                    type: 'string',
                    example: '2021-01-03T02:30:00+01:00',
                ),
                new OA\Property(
                    property: ParametersList::UPDATED_AT,
                    description: 'Product was updated at',
                    type: 'string',
                    example: '2021-01-03T02:30:00+01:00',
                ),
                new OA\Property(
                    property: ParametersList::DELETED_AT,
                    description: 'Product was deleted at',
                    type: 'string',
                    example: '2021-01-03T02:30:00+01:00',
                ),
            ]
        );
    }
}

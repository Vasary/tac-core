<?php

declare(strict_types = 1);

namespace App\Infrastructure\OpenAPI\Product;

use App\Infrastructure\Map\ParametersList;
use OpenApi\Attributes as OA;

final class AttributeValueSchema extends OA\Schema
{
    public function __construct()
    {
        parent::__construct(
            properties: [
                new OA\Property(
                    property: ParametersList::ID,
                    description: 'Unique unit id',
                    type: 'string',
                    example: '147e4f94-315a-46df-a3d5-b9f3bfff3177',
                ),
                new OA\Property(
                    property: ParametersList::ATTRIBUTE,
                    ref: '#/components/schemas/Attribute',
                    description: 'Attribute data',
                    type: 'object',
                ),
                new OA\Property(
                    property: ParametersList::PARENT,
                    description: 'Parameter parent id',
                    type: 'string',
                    example: 'cbff345a-b4e0-4f6d-800f-48012ae803bd',
                    nullable: true,
                ),
                new OA\Property(
                    property: ParametersList::CREATOR,
                    description: 'Person Id who creates unit',
                    type: 'string',
                    example: 'foo@bar.com'
                ),
                new OA\Property(
                    property: ParametersList::CREATED_AT,
                    description: 'Unit was created at',
                    type: 'string',
                    example: '2021-01-03T02:30:00+01:00',
                ),
                new OA\Property(
                    property: ParametersList::UPDATED_AT,
                    description: 'Unit was updated at',
                    type: 'string',
                    example: '2021-01-03T02:30:00+01:00',
                ),
                new OA\Property(
                    property: ParametersList::DELETED_AT,
                    description: 'Unit was deleted at',
                    type: 'string',
                    example: '2021-01-03T02:30:00+01:00',
                ),
            ]
        );
    }
}

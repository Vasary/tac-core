<?php

declare(strict_types = 1);

namespace App\Infrastructure\OpenAPI\Attribute;

use App\Infrastructure\Map\ParametersList;
use OpenApi\Attributes as OA;

final class AttributeSchema extends OA\Schema
{
    public function __construct()
    {
        parent::__construct(
            properties: [
                new OA\Property(
                    property: ParametersList::ID,
                    description: 'Unique attribute id',
                    type: 'string',
                    example: '147e4f94-315a-46df-a3d5-b9f3bfff3177',
                ),
                new OA\Property(
                    property: ParametersList::NAME,
                    description: 'Attribute name',
                    type: 'string',
                    example: 'Name'
                ),
                new OA\Property(
                    property: ParametersList::CODE,
                    description: 'Unique attribute code',
                    type: 'string',
                    example: 'name'
                ),
                new OA\Property(
                    property: ParametersList::DESCRIPTION,
                    description: 'Attribute description',
                    type: 'string',
                    example: 'This attribute describes product name'
                ),
                new OA\Property(
                    property: ParametersList::TYPE,
                    description: 'Attribute type',
                    type: 'string',
                    example: 'Attribute data type'
                ),
                new OA\Property(
                    property: ParametersList::CREATOR,
                    description: 'Person Id who creates attribute',
                    type: 'string',
                    example: 'foo@bar.com'
                ),
                new OA\Property(
                    property: ParametersList::CREATED_AT,
                    description: 'Attribute was created at',
                    type: 'string',
                    example: '2021-01-03T02:30:00+01:00',
                ),
                new OA\Property(
                    property: ParametersList::UPDATED_AT,
                    description: 'Attribute was updated at',
                    type: 'string',
                    example: '2021-01-03T02:30:00+01:00',
                ),
                new OA\Property(
                    property: ParametersList::DELETED_AT,
                    description: 'Attribute was deleted at',
                    type: 'string',
                    example: '2021-01-03T02:30:00+01:00',
                ),
            ]
        );
    }
}

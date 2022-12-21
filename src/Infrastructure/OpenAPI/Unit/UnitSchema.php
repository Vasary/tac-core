<?php

declare(strict_types=1);

namespace App\Infrastructure\OpenAPI\Unit;

use App\Infrastructure\Map\ParametersList;
use OpenApi\Attributes as OA;

class UnitSchema extends OA\Schema
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
                    property: ParametersList::NAME,
                    description: 'Unit name',
                    type: 'string',
                    example: 'Kilogram'
                ),
                new OA\Property(
                    property: ParametersList::ALIAS,
                    description: 'Unique short name',
                    type: 'string',
                    example: 'KG'
                ),
                new OA\Property(
                    property: ParametersList::SUGGESTIONS,
                    description: 'An array of integer for input suggestion',
                    type: 'string',
                    example: [10, 20, 30]
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

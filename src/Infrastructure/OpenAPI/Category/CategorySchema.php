<?php

declare(strict_types = 1);

namespace App\Infrastructure\OpenAPI\Category;

use App\Infrastructure\Map\ParametersList;
use OpenApi\Attributes as OA;

final class CategorySchema extends OA\Schema
{
    public function __construct()
    {
        parent::__construct(
            properties: [
                new OA\Property(
                    property: ParametersList::ID,
                    description: 'Unique category id',
                    type: 'string',
                    example: '48417967-cc95-4b4f-b69b-4e7cd422ff1a',
                ),
                new OA\Property(
                    property: ParametersList::NAME,
                    description: 'Category name',
                    type: 'string',
                    example: 'Liquid'
                ),
                new OA\Property(
                    property: ParametersList::CREATOR,
                    description: 'Person Id who creates category',
                    type: 'string',
                    example: 'foo@bar.com'
                ),
                new OA\Property(
                    property: ParametersList::CREATED_AT,
                    description: 'Category was created at',
                    type: 'string',
                    example: '2021-01-03T02:30:00+01:00',
                ),
                new OA\Property(
                    property: ParametersList::UPDATED_AT,
                    description: 'Category was updated at',
                    type: 'string',
                    example: '2021-01-03T02:30:00+01:00',
                ),
                new OA\Property(
                    property: ParametersList::DELETED_AT,
                    description: 'Category was deleted at',
                    type: 'string',
                    example: '2021-01-03T02:30:00+01:00',
                ),
            ]
        );
    }
}

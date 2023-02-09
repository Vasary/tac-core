<?php

declare(strict_types = 1);

namespace App\Infrastructure\OpenAPI\AttributeValue;

use App\Infrastructure\Map\ParametersList;
use Attribute;
use OpenApi\Attributes as OA;

#[Attribute(Attribute::IS_REPEATABLE | Attribute::TARGET_CLASS | Attribute::TARGET_METHOD)]
final class AttributeSchema extends OA\Schema
{
    public function __construct()
    {
        parent::__construct(
            schema: 'Attribute',
            properties: [
                new OA\Property(
                    property: ParametersList::ID,
                    description: 'Attribute id',
                    type: 'string',
                    example: 'd2f1c238-5fc0-4a98-b659-640f12aca8a8',
                ),
                new OA\Property(
                    property: ParametersList::CODE,
                    description: 'Attribute code name',
                    type: 'string',
                    example: 'name',
                ),

                new OA\Property(
                    property: ParametersList::TYPE,
                    description: 'Attribute type: [int, string, array, ...]',
                    type: 'string',
                    enum: ['array', 'string', 'boolean', 'integer', 'float'],
                    example: 'string',
                ),
                new OA\Property(
                    property: ParametersList::NAME,
                    description: 'Human readable attribute name',
                    type: 'string',
                    example: 'Name',
                ),
                new OA\Property(
                    property: ParametersList::DESCRIPTION,
                    description: 'Human readable attribute description',
                    type: 'string',
                    example: 'This attribute describes product name',
                ),
                new OA\Property(
                    property: ParametersList::VALUE,
                    description: 'A',
                    type: 'string',
                    example: 'This attribute describes product name',
                ),
            ]
        );
    }
}

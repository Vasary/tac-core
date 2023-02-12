<?php

declare(strict_types = 1);

namespace App\Infrastructure\OpenAPI\Attribute;

use App\Infrastructure\Map\ParametersList;
use Attribute;
use OpenApi\Attributes as OA;

#[Attribute(Attribute::IS_REPEATABLE | Attribute::TARGET_CLASS | Attribute::TARGET_METHOD)]
final class CreateRequest extends OA\RequestBody
{
    public function __construct()
    {
        parent::__construct(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(
                        property: ParametersList::NAME,
                        description: 'Attribute name',
                        type: 'string',
                        example: 'Name'
                    ),
                    new OA\Property(
                        property: ParametersList::DESCRIPTION,
                        description: 'Attribute description',
                        type: 'string',
                        example: 'Name'
                    ),
                    new OA\Property(
                        property: ParametersList::CODE,
                        description: 'Attribute code',
                        type: 'string',
                        example: 'name'
                    ),
                    new OA\Property(
                        property: ParametersList::TYPE,
                        description: 'Attribute type',
                        type: 'string',
                        enum: ['array', 'string', 'boolean', 'integer', 'float'],
                    ),
                ]
            )
        );
    }
}

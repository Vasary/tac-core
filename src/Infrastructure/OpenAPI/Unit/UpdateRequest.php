<?php

declare(strict_types=1);

namespace App\Infrastructure\OpenAPI\Unit;

use App\Infrastructure\Map\ParametersList;
use Attribute;
use OpenApi\Attributes as OA;

#[Attribute(Attribute::IS_REPEATABLE | Attribute::TARGET_CLASS | Attribute::TARGET_METHOD)]
class UpdateRequest extends OA\RequestBody
{
    public function __construct()
    {
        parent::__construct(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(
                        property: ParametersList::ID,
                        description: 'Unit ID',
                        type: 'string',
                        example: 'f387055c-8f88-48d2-a231-fa9947889896'
                    ),
                    new OA\Property(
                        property: ParametersList::NAME,
                        description: 'Unit name',
                        type: 'string',
                        example: 'Liter'
                    ),
                    new OA\Property(
                        property: ParametersList::ALIAS,
                        description: 'Unit short name',
                        type: 'string',
                        example: 'L'
                    ),
                    new OA\Property(
                        property: ParametersList::SUGGESTIONS,
                        description: 'An array of integers which suggests as a size hint',
                        type: 'array',
                        items: new OA\Items(
                            type: 'integer',
                            example: [10, 20, 30, 40, 50]
                        )
                    ),
                ]
            )
        );
    }
}

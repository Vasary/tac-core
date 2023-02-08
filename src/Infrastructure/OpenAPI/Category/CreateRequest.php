<?php

declare(strict_types = 1);

namespace App\Infrastructure\OpenAPI\Category;

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
                        description: 'Category name',
                        type: 'string',
                        example: 'Liquid'
                    ),
                ]
            )
        );
    }
}

<?php

declare(strict_types = 1);

namespace App\Infrastructure\OpenAPI\Category;

use App\Infrastructure\Map\ParametersList;
use Attribute;
use OpenApi\Attributes as OA;

#[Attribute(Attribute::IS_REPEATABLE | Attribute::TARGET_CLASS | Attribute::TARGET_METHOD)]
final class GetCategoriesResponse extends OA\Response
{
    public function __construct()
    {
        parent::__construct(
            response: 200,
            description: 'Get list of categories',
            content: new OA\MediaType(
                mediaType: 'application/json',
                schema: new OA\Schema(
                    properties: [
                        new OA\Property(
                            property: ParametersList::TOTAL,
                            description: 'Total items in the result',
                            type: 'integer',
                            example: 1,
                        ),
                        new OA\Property(
                            property: ParametersList::ITEMS,
                            description: 'Total items in the result',
                            type: 'array',
                            items: new OA\Items(
                                oneOf: [new CategorySchema()]
                            )
                        ),
                    ]
                )
            )
        );
    }
}

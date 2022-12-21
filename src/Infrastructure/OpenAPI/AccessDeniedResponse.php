<?php

declare(strict_types=1);

namespace App\Infrastructure\OpenAPI;

use App\Infrastructure\Map\ParametersList;
use Attribute;
use OpenApi\Attributes as OA;

#[Attribute(Attribute::IS_REPEATABLE | Attribute::TARGET_CLASS | Attribute::TARGET_METHOD)]
class AccessDeniedResponse extends OA\Response
{
    public function __construct()
    {
        parent::__construct(
            response: 401,
            description: 'Access denied',
            content: new OA\MediaType(
                mediaType: 'application/json',
                schema: new OA\Schema(
                    properties: [
                        new OA\Property(
                            property: ParametersList::CODE,
                            description: 'System error code',
                            type: 'integer'
                        ),
                        new OA\Property(
                            property: ParametersList::MESSAGE,
                            description: 'System error code description',
                            type: 'string'
                        ),
                    ]
                )
            )
        );
    }
}

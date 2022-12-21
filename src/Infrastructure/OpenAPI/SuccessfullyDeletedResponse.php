<?php

declare(strict_types=1);

namespace App\Infrastructure\OpenAPI;

use App\Infrastructure\Map\ParametersList;
use Attribute;
use OpenApi\Attributes as OA;

#[Attribute(Attribute::IS_REPEATABLE | Attribute::TARGET_CLASS | Attribute::TARGET_METHOD)]
class SuccessfullyDeletedResponse extends OA\Response
{
    public function __construct()
    {
        parent::__construct(
            response: 200,
            description: 'Successfully deleted response',
            content: new OA\MediaType(
                mediaType: 'application/json',
                schema: new OA\Schema(
                    properties: [
                        new OA\Property(
                            property: ParametersList::STATUS,
                            description: 'System response code',
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

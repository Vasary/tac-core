<?php

declare(strict_types = 1);

namespace App\Infrastructure\OpenAPI\Unit;

use Attribute;
use OpenApi\Attributes as OA;

#[Attribute(Attribute::IS_REPEATABLE | Attribute::TARGET_CLASS | Attribute::TARGET_METHOD)]
final class GetUnitResponse extends OA\Response
{
    public function __construct()
    {
        parent::__construct(
            response: 200,
            description: 'Get unit by id response',
            content: new OA\MediaType(
                mediaType: 'application/json',
                schema: new UnitSchema()
            )
        );
    }
}

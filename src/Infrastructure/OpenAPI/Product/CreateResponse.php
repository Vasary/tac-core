<?php

declare(strict_types = 1);

namespace App\Infrastructure\OpenAPI\Product;

use Attribute;
use OpenApi\Attributes as OA;

#[Attribute(Attribute::IS_REPEATABLE | Attribute::TARGET_CLASS | Attribute::TARGET_METHOD)]
final class CreateResponse extends OA\Response
{
    public function __construct()
    {
        parent::__construct(
            response: 201,
            description: 'Get created product response',
            content: new OA\MediaType(
                mediaType: 'application/json',
                schema: new ProductSchema()
            )
        );
    }
}
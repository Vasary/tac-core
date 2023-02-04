<?php

declare(strict_types=1);

namespace App\Infrastructure\OpenAPI;

use Attribute;
use OpenApi\Attributes as OA;

#[Attribute(Attribute::IS_REPEATABLE | Attribute::TARGET_CLASS | Attribute::TARGET_METHOD)]
class Put extends OA\Put
{
    public function __construct(string $path)
    {
        parent::__construct(path: $path);
    }
}
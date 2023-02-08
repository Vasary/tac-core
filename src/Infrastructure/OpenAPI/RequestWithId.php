<?php

declare(strict_types = 1);

namespace App\Infrastructure\OpenAPI;

use Attribute;
use OpenApi\Attributes as OA;

#[Attribute(Attribute::IS_REPEATABLE | Attribute::TARGET_CLASS | Attribute::TARGET_METHOD)]
final class RequestWithId extends OA\Parameter
{
    public function __construct()
    {
        parent::__construct(
            name: 'id',
            description: 'Model ID',
            in: 'path',
            required: true,
            schema: new OA\Schema(type: 'string'),
            example: '15629f90-a533-4976-aa04-d1dae546c51f'
        );
    }
}

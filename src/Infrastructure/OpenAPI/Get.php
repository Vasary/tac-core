<?php

declare(strict_types = 1);

namespace App\Infrastructure\OpenAPI;

use Attribute;
use OpenApi\Attributes as OA;

#[Attribute(Attribute::IS_REPEATABLE | Attribute::TARGET_CLASS | Attribute::TARGET_METHOD)]
final class Get extends OA\Get
{
    public function __construct(string $path, string $group, bool $pagination = false)
    {
        $parameters = [];
        if ($pagination) {
            $parameters = [
                $this->getQueryParameter('page', 'Page number'),
                $this->getQueryParameter('size', 'Page size'),
            ];
        }

        parent::__construct(path: $path, security: [['OAuth2' => ['openid']]], tags: [$group], parameters: $parameters);
    }

    private function getQueryParameter(string $name, string $description): OA\QueryParameter
    {
        return new OA\QueryParameter(
            name: $name,
            description: $description,
            required: true,
            schema: new OA\Schema(type: 'integer')
        );
    }
}

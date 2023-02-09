<?php

declare(strict_types = 1);

namespace App\Infrastructure\OpenAPI;

use Attribute;
use OpenApi\Attributes as OA;

#[Attribute(Attribute::IS_REPEATABLE | Attribute::TARGET_CLASS | Attribute::TARGET_METHOD)]
final class Post extends OA\Post
{
    public function __construct(string $path, string $group)
    {
        parent::__construct(path: $path, security: [['OAuth2' => ['openid']]], tags: [$group]);
    }
}

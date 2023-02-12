<?php

declare(strict_types = 1);

namespace App\Infrastructure\OpenAPI;

use Attribute;
use OpenApi\Attributes as OA;

#[Attribute(Attribute::IS_REPEATABLE | Attribute::TARGET_CLASS | Attribute::TARGET_METHOD)]
final class Info extends OA\OpenApi
{
    public function __construct()
    {
        parent::__construct(
            info: new OA\Info(
                version: '0.1.0',
                description: 'Management API for TAC project',
                title: 'Core management api',
                contact: new OA\Contact(
                    name: 'Viktor Gievoi',
                    email: 'gievoi.v@gmail.com'
                ),
            ),
            servers: [
                new OA\Server(
                    url: 'http://core.dev.tac.com',
                    description: 'Staging server',
                ),
            ],
            security: [
                [
                    'OAuth2' => ['openid', 'admin:org'],
                ],
            ],
            components: new OA\Components(
                securitySchemes: [
                    new Security(),
                ]
            ),
        );
    }
}

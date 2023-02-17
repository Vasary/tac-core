<?php

declare(strict_types = 1);

namespace App\Infrastructure\OpenAPI;

use OpenApi\Attributes as OA;

final class Security extends OA\SecurityScheme
{
    public function __construct()
    {
        parent::__construct(
            securityScheme: 'OAuth2',
            type: 'oauth2',
            description: 'This API uses OAuth 2 with the implicit grant flow',
            bearerFormat: 'JWT',
            flows: [
                new OA\Flow(
                    authorizationUrl: 'https://tac01-dev.eu.auth0.com/authorize?audience=https://tac01-dev.eu.auth0.com/api/v2/',
                    tokenUrl: 'https://tac01-dev.eu.auth0.com/oauth/token',
                    flow: 'pkce',
                    scopes: [
                        'openid' => 'Grants access to OpenId',
                    ]
                ),
            ],
        );
    }
}

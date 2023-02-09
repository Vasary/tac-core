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
            flows: [
                new OA\Flow(
                    authorizationUrl: 'https://tac01-dev.eu.auth0.com/authorize',
                    tokenUrl: 'https://tac01-dev.eu.auth0.com/userinfo',
                    flow: 'authorizationCode',
                    scopes: [
                        'openid' => 'Grants access to user_id',
                        'admin:org' => 'Fully manage organization, teams, and memberships.',
                    ]
                ),
            ],
        );
    }
}

// https://tac01-dev.eu.auth0.com?audience=https://tac01-dev.eu.auth0.com/api/v2/

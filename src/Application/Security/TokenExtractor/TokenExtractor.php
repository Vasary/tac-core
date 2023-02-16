<?php

declare(strict_types=1);

namespace App\Application\Security\TokenExtractor;

use InvalidArgumentException;

class TokenExtractor
{
    /**
     * @var string
     */
    private const ALLOWED_TOKEN_TYPE = 'Bearer';

    public function extract(string $authorizationToken): string
    {
        $authorizationTokenParts = explode(' ', $authorizationToken);

        if (count($authorizationTokenParts) !== 2) {
            throw new InvalidArgumentException('Invalid token format');
        }

        [$type, $token] = $authorizationTokenParts;

        if ($type !== self::ALLOWED_TOKEN_TYPE) {
            throw new InvalidArgumentException('Invalid token type');
        }

        if (!$token) {
            throw new InvalidArgumentException('Token can\'t be empty');
        }

        return $token;
    }
}

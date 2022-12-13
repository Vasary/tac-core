<?php

declare(strict_types=1);

namespace App\Application\Security\Authenticator;

use App\Infrastructure\Response\JsonResponse;

final class AccessDeniedResponse extends JsonResponse
{
    public function __construct(array $data)
    {
        parent::__construct($data, 401);
    }
}

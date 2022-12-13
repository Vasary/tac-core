<?php

declare(strict_types=1);

namespace App\Infrastructure\Response;

use Symfony\Component\HttpFoundation\JsonResponse as SymfonyJsonResponse;

abstract class JsonResponse extends SymfonyJsonResponse
{
}

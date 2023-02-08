<?php

declare(strict_types = 1);

namespace App\Presentation\API\Attributes\Delete\Response;

use App\Infrastructure\Response\JsonResponse;

final class AttributeDeleteResponse extends JsonResponse
{
    public function __construct()
    {
        parent::__construct([
            'status' => 200,
            'message' => 'Successfully removed',
        ]);
    }
}

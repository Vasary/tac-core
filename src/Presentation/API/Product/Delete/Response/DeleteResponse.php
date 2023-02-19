<?php

declare(strict_types = 1);

namespace App\Presentation\API\Product\Delete\Response;

use App\Infrastructure\Response\JsonResponse;

final class DeleteResponse extends JsonResponse
{
    public function __construct()
    {
        parent::__construct([
            'status' => 200,
            'message' => 'Successfully removed',
        ]);
    }
}

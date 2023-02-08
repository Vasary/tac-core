<?php

declare(strict_types = 1);

namespace App\Presentation\API\Category\Delete\Response;

use App\Infrastructure\Response\JsonResponse;

final class CategoryDeleteResponse extends JsonResponse
{
    public function __construct()
    {
        parent::__construct([
            'status' => 200,
            'message' => 'Successfully removed',
        ]);
    }
}

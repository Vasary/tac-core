<?php

declare(strict_types=1);

namespace App\Presentation\API\Category\Update\Response;

use App\Domain\Model\Category;
use App\Infrastructure\Response\JsonResponse;
use App\Infrastructure\Serializer\Serializer;

final class UpdateCategoryResponse extends JsonResponse
{
    public function __construct(Category $category)
    {
        parent::__construct(Serializer::create()->toArray($category));
    }
}

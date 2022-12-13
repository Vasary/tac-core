<?php

declare(strict_types=1);

namespace App\Presentation\API\Category\Get\Response;

use App\Domain\Model\Category;
use App\Infrastructure\Response\JsonResponse;
use App\Infrastructure\Serializer\Serializer;

final class GetResponse extends JsonResponse
{
    public function __construct(Category $category)
    {
        parent::__construct($this->build($category));
    }

    private function build(Category $category): array
    {
        return Serializer::create()->toArray($category);
    }
}

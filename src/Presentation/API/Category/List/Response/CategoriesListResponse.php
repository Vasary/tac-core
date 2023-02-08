<?php

declare(strict_types = 1);

namespace App\Presentation\API\Category\List\Response;

use App\Domain\Model\Category;
use App\Infrastructure\Response\JsonResponse;
use App\Infrastructure\Serializer\Serializer;
use Generator;

final class CategoriesListResponse extends JsonResponse
{
    public function __construct(Generator $categories, int $total)
    {
        parent::__construct(
            [
                'items' => $this->build($categories),
                'total' => $total,
            ]
        );
    }

    private function build(Generator $categories): array
    {
        $serializer = Serializer::create();

        return array_map(
            fn (Category $category) => $serializer->toArray($category),
            iterator_to_array($categories)
        );
    }
}

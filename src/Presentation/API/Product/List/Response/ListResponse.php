<?php

declare(strict_types=1);

namespace App\Presentation\API\Product\List\Response;

use App\Domain\Model\Product;
use App\Infrastructure\Response\JsonResponse;
use App\Infrastructure\Serializer\Serializer;
use Generator;

final class ListResponse extends JsonResponse
{
    public function __construct(Generator $products, int $total)
    {
        parent::__construct(
            [
                'items' => $this->build($products),
                'total' => $total,
            ]
        );
    }

    private function build(Generator $products): array
    {
        $serializer = Serializer::create();

        return array_map(
            fn (Product $product) => $serializer->toArray($product),
            iterator_to_array($products)
        );
    }
}

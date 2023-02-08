<?php

declare(strict_types = 1);

namespace App\Presentation\API\Attributes\List\Response;

use App\Domain\Model\Attribute;
use App\Infrastructure\Response\JsonResponse;
use App\Infrastructure\Serializer\Serializer;
use Generator;

final class AttributesListResponse extends JsonResponse
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
            fn (Attribute $product) => $serializer->toArray($product),
            iterator_to_array($products)
        );
    }
}

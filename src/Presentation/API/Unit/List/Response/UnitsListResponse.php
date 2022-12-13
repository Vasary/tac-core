<?php

declare(strict_types=1);

namespace App\Presentation\API\Unit\List\Response;

use App\Domain\Model\Unit;
use App\Infrastructure\Response\JsonResponse;
use App\Infrastructure\Serializer\Serializer;
use Generator;

final class UnitsListResponse extends JsonResponse
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
            fn (Unit $product) => $serializer->toArray($product),
            iterator_to_array($products)
        );
    }
}

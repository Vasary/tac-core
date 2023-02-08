<?php

declare(strict_types = 1);

namespace App\Presentation\API\Product\Create\Response;

use App\Domain\Model\Product;
use App\Infrastructure\Response\JsonResponse;
use App\Infrastructure\Serializer\Serializer;

final class CreateResponse extends JsonResponse
{
    public function __construct(Product $product)
    {
        parent::__construct($this->build($product), 201);
    }

    private function build(Product $product): array
    {
        return Serializer::create()->toArray($product);
    }
}

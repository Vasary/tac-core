<?php

declare(strict_types=1);

namespace App\Presentation\API\Product\Update\Response;

use App\Domain\Model\Product;
use App\Infrastructure\Response\JsonResponse;
use App\Infrastructure\Serializer\Serializer;

final class UpdateProductResponse extends JsonResponse
{
    public function __construct(Product $product)
    {
        parent::__construct(Serializer::create()->toArray($product));
    }
}

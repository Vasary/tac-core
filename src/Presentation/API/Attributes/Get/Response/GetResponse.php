<?php

declare(strict_types = 1);

namespace App\Presentation\API\Attributes\Get\Response;

use App\Domain\Model\Attribute;
use App\Infrastructure\Response\JsonResponse;
use App\Infrastructure\Serializer\Serializer;

final class GetResponse extends JsonResponse
{
    public function __construct(Attribute $attribute)
    {
        parent::__construct($this->build($attribute));
    }

    private function build(Attribute $attribute): array
    {
        return Serializer::create()->toArray($attribute);
    }
}

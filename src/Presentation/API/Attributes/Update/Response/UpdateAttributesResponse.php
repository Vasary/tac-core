<?php

declare(strict_types = 1);

namespace App\Presentation\API\Attributes\Update\Response;

use App\Domain\Model\Attribute;
use App\Infrastructure\Response\JsonResponse;
use App\Infrastructure\Serializer\Serializer;

final class UpdateAttributesResponse extends JsonResponse
{
    public function __construct(Attribute $attribute)
    {
        parent::__construct(Serializer::create()->toArray($attribute));
    }
}

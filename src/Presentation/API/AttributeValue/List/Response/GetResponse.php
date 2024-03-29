<?php

declare(strict_types = 1);

namespace App\Presentation\API\AttributeValue\List\Response;

use App\Domain\Model\AttributeValue;
use App\Infrastructure\Response\JsonResponse;
use App\Infrastructure\Serializer\Serializer;
use Generator;

final class GetResponse extends JsonResponse
{
    public function __construct(Generator $attributes, int $total)
    {
        parent::__construct(
            [
                'total' => $total,
                'items' => array_map(
                    fn(AttributeValue $attribute) => Serializer::create()->toArray($attribute),
                    iterator_to_array($attributes)
                ),
            ]
        );
    }
}

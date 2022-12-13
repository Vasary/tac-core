<?php

declare(strict_types=1);

namespace App\Infrastructure\Serializer\Normalizer;

use App\Domain\Model\Attribute;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

final class AttributeNormalizer implements NormalizerInterface
{
    public function normalize(mixed $object, string $format = null, array $context = []): array
    {
        /* @var Attribute $object */
        return
            [
                'id' => (string) $object->getId(),
                'code' => $object->getCode(),
                'name' => (string) $object->getName(),
                'type' => (string) $object->getType(),
                'description' => (string) $object->getDescription(),
                'creator' => [
                    'identifier' => $object->getCreator()->getEmail(),
                ],
                'createdAt' => $object->getCreatedAt()->format(\DATE_ATOM),
                'updatedAt' => $object->getUpdatedAt()->format(\DATE_ATOM),
                'deletedAt' => $object->getDeletedAt()?->format(\DATE_ATOM),
            ];
    }

    public function supportsNormalization($data, string $format = null, array $context = []): bool
    {
        return $data instanceof Attribute;
    }
}

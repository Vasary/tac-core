<?php

declare(strict_types=1);

namespace App\Infrastructure\Serializer\Normalizer;

use App\Domain\Model\Category;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

final class CategoryNormalizer implements NormalizerInterface
{
    public function normalize(mixed $object, string $format = null, array $context = []): array
    {
        /* @var Category $object */
        return
            [
                'id' => (string)$object->getId(),
                'name' => (string)$object->getName(),
                'creator' => $object->getCreator()->getEmail(),
                'createdAt' => $object->getCreatedAt()->format(\DATE_ATOM),
                'updatedAt' => $object->getUpdatedAt()->format(\DATE_ATOM),
                'deletedAt' => $object->getDeletedAt()?->format(\DATE_ATOM),
            ];
    }

    public function supportsNormalization($data, string $format = null, array $context = []): bool
    {
        return $data instanceof Category;
    }
}

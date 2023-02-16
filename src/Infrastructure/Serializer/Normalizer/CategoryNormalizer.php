<?php

declare(strict_types = 1);

namespace App\Infrastructure\Serializer\Normalizer;

use App\Domain\Model\Category;
use App\Infrastructure\Map\ParametersList;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

final class CategoryNormalizer implements NormalizerInterface
{
    public function normalize(mixed $object, string $format = null, array $context = []): array
    {
        /* @var Category $object */
        return
            [
                ParametersList::ID => (string)$object->getId(),
                ParametersList::NAME => (string)$object->getName(),
                ParametersList::CREATOR => $object->getCreator()->getSsoId(),
                ParametersList::CREATED_AT => $object->getCreatedAt()->format(\DATE_ATOM),
                ParametersList::UPDATED_AT => $object->getUpdatedAt()->format(\DATE_ATOM),
                ParametersList::DELETED_AT => $object->getDeletedAt()?->format(\DATE_ATOM),
            ];
    }

    public function supportsNormalization(mixed $data, string $format = null, array $context = []): bool
    {
        return $data instanceof Category;
    }
}

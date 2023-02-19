<?php

declare(strict_types = 1);

namespace App\Infrastructure\Serializer\Normalizer;

use App\Domain\Model\Attribute;
use App\Infrastructure\Map\ParametersList;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

final class AttributeNormalizer implements NormalizerInterface
{
    public function normalize(mixed $object, string $format = null, array $context = []): array
    {
        /* @var Attribute $object */
        return
            [
                ParametersList::ID => (string) $object->getId(),
                ParametersList::CODE => $object->getCode(),
                ParametersList::NAME => (string) $object->getName(),
                ParametersList::TYPE => (string) $object->getType(),
                ParametersList::DESCRIPTION => (string) $object->getDescription(),
                ParametersList::CREATOR => $object->getCreator()->getSsoId(),
                ParametersList::CREATED_AT => $object->getCreatedAt()->format(\DATE_ATOM),
                ParametersList::UPDATED_AT => $object->getUpdatedAt()->format(\DATE_ATOM),
                ParametersList::DELETED_AT => $object->getDeletedAt()?->format(\DATE_ATOM),
            ];
    }

    public function supportsNormalization(mixed $data, string $format = null, array $context = []): bool
    {
        return $data instanceof Attribute;
    }
}

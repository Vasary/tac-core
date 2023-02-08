<?php

declare(strict_types = 1);

namespace App\Infrastructure\Serializer\Normalizer;

use App\Domain\Model\AttributeValue;
use App\Domain\Model\Product;
use App\Domain\Model\Unit;
use App\Infrastructure\Map\ParametersList;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

final class ProductNormalizer implements NormalizerInterface, NormalizerAwareInterface
{
    use NormalizerAwareTrait;

    public function normalize(mixed $object, string $format = null, array $context = []): array
    {
        /* @var Product $object */
        return
            [
                ParametersList::ID => (string)$object->getId(),
                ParametersList::NAME => (string)$object->getName(),
                ParametersList::DESCRIPTION => (string)$object->getDescription(),
                ParametersList::CREATOR => $object->getCreator()->getEmail(),
                ParametersList::ATTRIBUTES => $this->normalizer->normalize(array_values($object->getAttributes()->toArray())),
                ParametersList::CATEGORY => (string)$object->getCategory()->getId(),
                ParametersList::UNITS => array_values(array_map(
                    fn(Unit $unit) => (string)$unit->getId(),
                    $object->getUnits()->toArray()
                )),
                ParametersList::CREATED_AT => $object->getCreatedAt()->format(\DATE_ATOM),
                ParametersList::UPDATED_AT => $object->getUpdatedAt()->format(\DATE_ATOM),
                ParametersList::DELETED_AT => $object->getDeletedAt()?->format(\DATE_ATOM),
            ];
    }

    public function supportsNormalization(mixed $data, string $format = null, array $context = []): bool
    {
        return $data instanceof Product;
    }
}

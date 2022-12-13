<?php

declare(strict_types=1);

namespace App\Infrastructure\Serializer\Normalizer;

use App\Domain\Model\AttributeValue;
use App\Domain\Model\Product;
use App\Domain\Model\Unit;
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
                'id' => (string)$object->getId(),
                'name' => (string)$object->getName(),
                'description' => (string)$object->getDescription(),
                'creator' => $object->getCreator()->getEmail(),
                'attributes' => $this->normalizer->normalize(array_values($object->getAttributes()->toArray())),
                'category' => (string)$object->getCategory()->getId(),
                'units' => array_values(array_map(
                    fn (Unit $unit) => (string)$unit->getId(),
                    $object->getUnits()->toArray()
                )),
                'createdAt' => $object->getCreatedAt()->format(\DATE_ATOM),
                'updatedAt' => $object->getUpdatedAt()->format(\DATE_ATOM),
                'deletedAt' => $object->getDeletedAt()?->format(\DATE_ATOM),
            ];
    }

    public function supportsNormalization($data, string $format = null, array $context = []): bool
    {
        return $data instanceof Product;
    }
}

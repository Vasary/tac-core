<?php

declare(strict_types=1);

namespace App\Infrastructure\Serializer\Normalizer;

use App\Domain\Factory\TypeFactory;
use App\Domain\Model\Attribute;
use App\Domain\Model\AttributeValue;
use RuntimeException;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

final class AttributeValueNormalizer implements NormalizerInterface
{
    public function normalize(mixed $object, string $format = null, array $context = []): array
    {
        /* @var AttributeValue $object */
        return
            [
                'id' => (string) $object->getId(),
                'attribute' => [
                    'id' => (string) $object->getAttribute()->getId(),
                    'code' => $object->getAttribute()->getCode(),
                    'type' => (string) $object->getAttribute()->getType(),
                    'name' => (string)$object->getAttribute()->getName(),
                    'description' => (string)$object->getAttribute()->getDescription(),
                    'value' => $this->castType($object->getValue(), $object->getAttribute()),
                ],
                'parent' => (string) $object->getParent(),
                'creator' => $object->getCreator()->getEmail(),
                'createdAt' => $object->getCreatedAt()->format(DATE_ATOM),
                'updatedAt' => $object->getUpdatedAt()->format(DATE_ATOM),
                'deletedAt' => $object->getDeletedAt()?->format(DATE_ATOM),
            ];
    }

    public function supportsNormalization($data, string $format = null, array $context = []): bool
    {
        return $data instanceof AttributeValue;
    }

    private function castType(AttributeValue\Value $value, Attribute $attribute): mixed
    {
        return match ((string) $attribute->getType()) {
            TypeFactory::TYPE_STRING => $value->getValue(),
            TypeFactory::TYPE_BOOLEAN => 'true' === $value->getValue(),
            TypeFactory::TYPE_INTEGER => (int) $value->getValue(),
            TypeFactory::TYPE_ARRAY => null,
            TypeFactory::TYPE_FLOAT => (float) $value->getValue(),
            default => throw new RuntimeException('There is not cast type policy'),
        };
    }
}

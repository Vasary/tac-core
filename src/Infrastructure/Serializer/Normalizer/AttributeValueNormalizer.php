<?php

declare(strict_types=1);

namespace App\Infrastructure\Serializer\Normalizer;

use App\Domain\Factory\TypeFactory;
use App\Domain\Model\Attribute;
use App\Domain\Model\AttributeValue;
use App\Infrastructure\Map\ParametersList;
use RuntimeException;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

final class AttributeValueNormalizer implements NormalizerInterface
{
    public function normalize(mixed $object, string $format = null, array $context = []): array
    {
        /* @var AttributeValue $object */
        return
            [
                ParametersList::ID => (string) $object->getId(),
                ParametersList::ATTRIBUTE => [
                    ParametersList::ID => (string) $object->getAttribute()->getId(),
                    ParametersList::CODE => $object->getAttribute()->getCode(),
                    ParametersList::TYPE => (string) $object->getAttribute()->getType(),
                    ParametersList::NAME => (string)$object->getAttribute()->getName(),
                    ParametersList::DESCRIPTION => (string)$object->getAttribute()->getDescription(),
                    ParametersList::VALUE => $this->castType($object->getValue(), $object->getAttribute()),
                ],
                ParametersList::PARENT => (string) $object->getParent(),
                ParametersList::CREATOR => $object->getCreator()->getEmail(),
                ParametersList::CREATED_AT => $object->getCreatedAt()->format(DATE_ATOM),
                ParametersList::UPDATED_AT => $object->getUpdatedAt()->format(DATE_ATOM),
                ParametersList::DELETED_AT => $object->getDeletedAt()?->format(DATE_ATOM),
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

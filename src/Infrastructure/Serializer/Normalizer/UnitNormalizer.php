<?php

declare(strict_types=1);

namespace App\Infrastructure\Serializer\Normalizer;

use App\Domain\Model\Unit;
use App\Domain\ValueObject\Suggestion;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

final class UnitNormalizer implements NormalizerInterface, NormalizerAwareInterface
{
    use NormalizerAwareTrait;

    public function normalize(mixed $object, string $format = null, array $context = []): array
    {
        /* @var Unit $object */
        return
            [
                'id' => (string) $object->getId(),
                'name' => (string)$object->getName(),
                'alias' => (string)$object->getAlias(),
                'suggestions' => array_map(
                    fn (Suggestion $suggestion) => $suggestion->getValue(),
                    $object->getSuggestions()->getSuggestions()
                ),
                'creator' => $object->getCreator()->getEmail(),
                'createdAt' => $object->getCreatedAt()->format(\DATE_ATOM),
                'updatedAt' => $object->getUpdatedAt()->format(\DATE_ATOM),
                'deletedAt' => $object->getDeletedAt()?->format(\DATE_ATOM),
            ];
    }

    public function supportsNormalization($data, string $format = null, array $context = []): bool
    {
        return $data instanceof Unit;
    }
}

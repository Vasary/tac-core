<?php

declare(strict_types = 1);

namespace App\Infrastructure\Serializer\Normalizer;

use App\Domain\Model\Unit;
use App\Domain\ValueObject\Suggestion;
use App\Infrastructure\Map\ParametersList;
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
                ParametersList::ID => (string)$object->getId(),
                ParametersList::NAME => (string)$object->getName(),
                ParametersList::ALIAS => (string)$object->getAlias(),
                ParametersList::SUGGESTIONS => array_map(
                    fn(Suggestion $suggestion) => $suggestion->getValue(),
                    $object->getSuggestions()->getSuggestions()
                ),
                ParametersList::CREATOR => $object->getCreator()->getEmail(),
                ParametersList::CREATED_AT => $object->getCreatedAt()->format(\DATE_ATOM),
                ParametersList::UPDATED_AT => $object->getUpdatedAt()->format(\DATE_ATOM),
                ParametersList::DELETED_AT => $object->getDeletedAt()?->format(\DATE_ATOM),
            ];
    }

    public function supportsNormalization(mixed $data, string $format = null, array $context = []): bool
    {
        return $data instanceof Unit;
    }
}

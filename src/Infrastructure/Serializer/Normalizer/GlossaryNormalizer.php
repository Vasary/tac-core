<?php

declare(strict_types = 1);

namespace App\Infrastructure\Serializer\Normalizer;

use App\Domain\Model\Glossary;
use App\Infrastructure\Map\ParametersList;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

final class GlossaryNormalizer implements NormalizerInterface
{
    public function normalize(mixed $object, string $format = null, array $context = []): array
    {
        /* @var Glossary $object */
        return
            [
                ParametersList::OBJECT_ID => (string) $object->parent(),
                ParametersList::FIELD => $object->field(),
                ParametersList::VALUE => $object->value(),
                ParametersList::LOCALE => (string)$object->locale(),
            ];
    }

    public function supportsNormalization(mixed $data, string $format = null, array $context = []): bool
    {
        return $data instanceof Glossary;
    }
}

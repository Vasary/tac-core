<?php

declare(strict_types=1);

namespace App\Infrastructure\Serializer\Normalizer;

use App\Domain\Model\Glossary;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

final class GlossaryNormalizer implements NormalizerInterface
{
    public function normalize(mixed $object, string $format = null, array $context = []): array
    {
        /* @var Glossary $object */
        return
            [
                'objectId' => (string) $object->parent(),
                'field' => $object->field(),
                'value' => $object->value(),
                'locale' => (string)$object->locale(),
            ];
    }

    public function supportsNormalization($data, string $format = null, array $context = []): bool
    {
        return $data instanceof Glossary;
    }
}

<?php

declare(strict_types = 1);

namespace App\Infrastructure\Persistence\Doctrine\Type;

use App\Domain\ValueObject\Suggestion;
use App\Domain\ValueObject\Suggestions;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\JsonType;

final class SuggestionsType extends JsonType
{
    private const NAME = 'suggestions';

    public function getName(): string
    {
        return self::NAME;
    }

    public function convertToPHPValue(mixed $value, AbstractPlatform $platform): ?Suggestions
    {
        if (null === $value) {
            return null;
        }

        $value = json_decode($value, true, JSON_THROW_ON_ERROR);

        if (!\is_array($value)) {
            throw ConversionException::conversionFailedInvalidType($value, $this->getName(), ['array']);
        }

        $suggestions = new Suggestions();

        foreach ($value as $suggestion) {
            $suggestions->addSuggestions(new Suggestion($suggestion));
        }

        return $suggestions;
    }

    /**
     * @param Suggestions $value
     */
    public function convertToDatabaseValue(mixed $value, AbstractPlatform $platform): string
    {
        if (!($value instanceof Suggestions)) {
            throw ConversionException::conversionFailedSerialization($value, 'json', 'Invalid value type');
        }

        $result = [];
        foreach ($value->getSuggestions() as $suggestion) {
            /** @var Suggestion $suggestion */
            $result[] = $suggestion->getValue();
        }

        return json_encode($result);
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }
}

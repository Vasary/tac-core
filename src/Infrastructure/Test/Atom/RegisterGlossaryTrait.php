<?php

declare(strict_types = 1);

namespace App\Infrastructure\Test\Atom;

use App\Domain\Model\Glossary;
use App\Domain\ValueObject\I18N;
use App\Domain\ValueObject\Id;
use App\Domain\ValueObject\Locale;
use Generator;
use ReflectionClass;
use ReflectionProperty;

trait RegisterGlossaryTrait
{
    public function spawnGlossaryFor(object $object, Locale $locale): Generator
    {
        $reflection = new ReflectionClass($object);

        foreach ($reflection->getProperties() as $property) {
            if ($this->shouldCreateGlossary($property)) {
                yield $this->createGlossary($object->getId(), $property->getValue($object), $property, $locale);
            }
        }
    }

    private function createGlossary(Id $parentId, I18N $i18N, ReflectionProperty $property, Locale $locale): Glossary
    {
        $reflection = new ReflectionClass(Glossary::class);
        $glossaryInstance = $reflection->newInstanceWithoutConstructor();

        $reflection->getProperty('id')->setValue($glossaryInstance, Id::fromString($this->generateRandomUuid()));
        $reflection->getProperty('field')->setValue($glossaryInstance, $property->getName());
        $reflection->getProperty('value')->setValue($glossaryInstance, $i18N->value());
        $reflection->getProperty('locale')->setValue($glossaryInstance, $locale);
        $reflection->getProperty('parentId')->setValue($glossaryInstance, $parentId);

        return $glossaryInstance;
    }

    private function shouldCreateGlossary(ReflectionProperty $property): bool
    {
        return I18N::class === $property->getType()->getName();
    }

    private function generateRandomUuid(): string
    {
        return sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff)
        );
    }
}

<?php

declare(strict_types = 1);

namespace App\Infrastructure\Persistence\Doctrine\Adapter;

use App\Domain\Model\Glossary;
use App\Domain\ValueObject\I18N;
use App\Infrastructure\Locale\LocaleProvider;
use Doctrine\ORM\EntityManagerInterface;
use ReflectionProperty;

final class TranslationLoader
{
    public function __construct(private readonly LocaleProvider $localeProvider,) {
    }

    public function findExistedTranslation(ReflectionProperty $property, object $object, EntityManagerInterface $manager): ?Glossary
    {
        return $this->findTranslation($property, $object, $manager);
    }

    public function loadTranslation(ReflectionProperty $property, object $object, EntityManagerInterface $entityManager): I18N
    {
        $translation = $this->findTranslation($property, $object, $entityManager);

        return null === $translation
            ? new I18N($this->getFallbackTranslation($object, $property))
            : new I18N($translation->value());
    }

    private function getFallbackTranslation(object $object, ReflectionProperty $property): string
    {
        return sprintf(
            '[Locale: %s]: ' .
            'here is not translation for id: %s and property: %s',
            $this->localeProvider->getLocale(),
            $object->getId(),
            $property->getName(),
        );
    }

    private function findTranslation(ReflectionProperty $property, object $object, EntityManagerInterface $manager): ?Glossary
    {
        $query = $manager
            ->createQueryBuilder()
            ->select('g')
            ->from(Glossary::class, 'g')
            ->where('g.parentId = :parentId')
            ->andWhere('g.locale = :locale')
            ->andWhere('g.field = :field')
            ->setParameter('parentId', $object->getId())
            ->setParameter('locale', $this->localeProvider->getLocale())
            ->setParameter('field', $property->getName())
            ->getQuery()
            ->getResult();

        if (count($query) > 0) {
            return array_shift($query);
        }

        return null;
    }
}

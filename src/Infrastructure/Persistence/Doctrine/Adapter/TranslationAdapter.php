<?php

declare(strict_types = 1);

namespace App\Infrastructure\Persistence\Doctrine\Adapter;

use App\Domain\Model\Glossary;
use App\Domain\ValueObject\I18N;
use App\Domain\ValueObject\Locale;
use App\Infrastructure\Locale\LocaleProvider;
use Doctrine\ORM\EntityManagerInterface;
use ReflectionProperty;

final class TranslationAdapter
{
    public function __construct(
        private readonly LocaleProvider $localeProvider,
        private readonly TranslationLoader $loader,
    ) {
    }

    public function setTranslation(ReflectionProperty $property, object $object, EntityManagerInterface $entityManager): void
    {
        $i18n = $this->loader->loadTranslation($property, $object, $entityManager);

        $property->setValue($object, $i18n);
    }

    public function isPropertyTranslatable(ReflectionProperty $property): bool
    {
        return I18N::class === $property->getType()?->getName();
    }

    public function upsertTranslation(ReflectionProperty $property, object $object, EntityManagerInterface $manager): void
    {
        if (null === $translation = $this->loader->findExistedTranslation($property, $object, $manager)) {
            $this->insertNewTranslation($property, $object, $manager);
        } else {
            $this->updateTranslation($property, $object, $manager, $translation);
        }
    }

    private function updateTranslation(ReflectionProperty $property, object $object, EntityManagerInterface $manager, Glossary $translation): void
    {
        $meta = $manager->getClassMetadata(Glossary::class);
        $method = 'get' . ucfirst($property->getName());

        /** @var I18N $i18n */
        $i18n = $object->{$method}();

        if ((string)$translation !== $i18n->value()) {
            $translation->setValue($i18n->value());

            $manager->getUnitOfWork()->persist($translation);
            $manager->getUnitOfWork()->computeChangeSet($meta, $translation);
        }
    }

    private function insertNewTranslation(ReflectionProperty $property, object $object, EntityManagerInterface $manager): void
    {
        $meta = $manager->getClassMetadata(Glossary::class);

        $method = 'get' . ucfirst($property->getName());
        /** @var I18N $i18n */
        $i18n = $object->{$method}();

        $locale = new Locale($this->localeProvider->getLocale());
        $glossary = new Glossary($property->getName(), $i18n->value(), $locale, $object->getId());

        $manager->getUnitOfWork()->persist($glossary);
        $manager->getUnitOfWork()->computeChangeSet($meta, $glossary);
    }
}

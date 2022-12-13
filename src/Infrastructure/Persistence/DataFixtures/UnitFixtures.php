<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\DataFixtures;

use App\Domain\Model\Unit;
use App\Domain\Model\User;
use App\Domain\ValueObject\I18N;
use App\Domain\ValueObject\Suggestion;
use App\Domain\ValueObject\Suggestions;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

final class UnitFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $user = $manager->getRepository(User::class)->findOneBy([]);

        $suggestions = new Suggestions();
        $suggestions
            ->addSuggestions(new Suggestion(1))
            ->addSuggestions(new Suggestion(2))
            ->addSuggestions(new Suggestion(3))
            ->addSuggestions(new Suggestion(4))
            ->addSuggestions(new Suggestion(5))
        ;

        $manager->persist(new Unit(new I18N('Kilogram'), new I18N('K'), $suggestions, $user));
        $manager->persist(new Unit(new I18N('Liter'), new I18N('L'), $suggestions, $user));

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }
}

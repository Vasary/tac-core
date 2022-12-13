<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\DataFixtures;

use App\Domain\Model\Category;
use App\Domain\Model\User;
use App\Domain\ValueObject\I18N;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

final class CategoryFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $user = $manager->getRepository(User::class)->findOneBy([]);

        $manager->persist(new Category(new I18N('Liquid'), $user));
        $manager->persist(new Category(new I18N('Vegetables'), $user));
        $manager->persist(new Category(new I18N('Meat'), $user));
        $manager->persist(new Category(new I18N('Fish'), $user));
        $manager->persist(new Category(new I18N('Sweets'), $user));

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }
}

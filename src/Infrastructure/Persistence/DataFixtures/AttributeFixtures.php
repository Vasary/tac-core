<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\DataFixtures;

use App\Domain\Model\Attribute;
use App\Domain\Model\Attribute\Type\ArrayType;
use App\Domain\Model\Attribute\Type\BooleanType;
use App\Domain\Model\Attribute\Type\IntegerType;
use App\Domain\Model\Attribute\Type\StringType;
use App\Domain\Model\User;
use App\Domain\ValueObject\I18N;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

final class AttributeFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $user = $manager->getRepository(User::class)->findOneBy([]);

        $attributes = [
            [
                'code' => 'color',
                'name' => 'Product color',
                'description' => 'This attribute describes product color',
                'type' => new StringType(),
            ],
            [
                'code' => 'weight',
                'name' => 'Product weight',
                'description' => 'This attribute describes product weight',
                'type' => new IntegerType(),
            ],
            [
                'code' => 'manufacturer',
                'name' => 'Product manufacturer',
                'description' => 'This attribute describes product manufacturer',
                'type' => new StringType(),
            ],
            [
                'code' => 'consist',
                'name' => 'Product consist',
                'description' => 'This attribute describes product consist',
                'type' => new ArrayType(),
            ],
            [
                'code' => 'sugar',
                'name' => 'Is sugar exists',
                'description' => 'Describe is product has sugar in consistency',
                'type' => new BooleanType(),
            ],
            [
                'code' => 'fats',
                'name' => 'Is fats exists',
                'description' => 'Describe is product has fats in consistency',
                'type' => new BooleanType(),
            ],
        ];

        foreach ($attributes as $attribute) {
            $manager->persist(new Attribute(
                $attribute['code'],
                new I18N($attribute['name']),
                new I18N($attribute['description']),
                $attribute['type'],
                $user
            ));
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }
}

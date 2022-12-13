<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\DataFixtures;

use App\Domain\Model\Attribute;
use App\Domain\Model\AttributeValue;
use App\Domain\Model\AttributeValue\Value;
use App\Domain\Model\Category;
use App\Domain\Model\Product;
use App\Domain\Model\Unit;
use App\Domain\Model\User;
use App\Domain\ValueObject\I18N;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

final class ProductFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $user = $manager->getRepository(User::class)->findOneBy([]);
        $category = $manager->getRepository(Category::class)->findOneBy([]);
        $unit = $manager->getRepository(Unit::class)->findOneBy([]);

        $attributeSugar = $manager->getRepository(Attribute::class)->findOneBy(['code' => 'sugar']);
        $attributeFats = $manager->getRepository(Attribute::class)->findOneBy(['code' => 'fats']);
        $attributeConsists = $manager->getRepository(Attribute::class)->findOneBy(['code' => 'consist']);
        $attributeManufacturer = $manager->getRepository(Attribute::class)->findOneBy(['code' => 'manufacturer']);
        $attributeWeight = $manager->getRepository(Attribute::class)->findOneBy(['code' => 'weight']);
        $attributeColor = $manager->getRepository(Attribute::class)->findOneBy(['code' => 'color']);

        $product = new Product(new I18N('Yogurt'), new I18N('Greek yogurt'), $user, $category);
        $product->addUnit($unit);

        $consistsAttributeValue = new AttributeValue($attributeConsists, new Value(null), $user);

        $product->addAttribute($consistsAttributeValue);
        $product->addAttribute(new AttributeValue($attributeSugar, new Value('true'), $user, $consistsAttributeValue->getAttribute()->getId()));
        $product->addAttribute(new AttributeValue($attributeFats, new Value('true'), $user, $consistsAttributeValue->getAttribute()->getId()));
        $product->addAttribute(new AttributeValue($attributeManufacturer, new Value('Danone'), $user));
        $product->addAttribute(new AttributeValue($attributeWeight, new Value('200'), $user));
        $product->addAttribute(new AttributeValue($attributeColor, new Value('#FFFFFF'), $user));

        $manager->persist($product);
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
            UnitFixtures::class,
            CategoryFixtures::class,
            AttributeFixtures::class,
        ];
    }
}

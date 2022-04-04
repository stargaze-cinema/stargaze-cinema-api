<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

final class CategoryFixtures extends Fixture
{
    public const NUMBER = 10;

    public function load(ObjectManager $manager): void
    {
        $generator = Factory::create();

        $category = new Category();
        $category->setName('Animation');
        $manager->persist($category);
        $this->addReference("category_0", $category);

        for ($i = 1; $i <= self::NUMBER; $i++) {
            $category = new Category();
            $category->setName($generator->colorName);
            $manager->persist($category);

            $this->addReference("category_$i", $category);
        }

        $manager->flush();
    }
}

<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $category = new Category();
        $category->setName('Cartoon');
        $manager->persist($category);
        $this->addReference('category_1', $category);

        $category = new Category();
        $category->setName('Action');
        $manager->persist($category);
        $this->addReference('category_2', $category);

        $manager->flush();
    }
}

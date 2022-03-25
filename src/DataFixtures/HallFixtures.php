<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Hall;
use App\Enum\HallType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class HallFixtures extends Fixture
{
    const NUMBER = 5;

    public function load(ObjectManager $manager): void
    {
        $generator = Factory::create();

        for ($i = 0; $i <= self::NUMBER; $i++) {
            $hall = new Hall();
            $hall->setName($generator->firstName);
            $hall->setCapacity($generator->numberBetween(0, 100));
            $hall->setType(HallType::getRandom()->value);
            $manager->persist($hall);

            $this->addReference("hall_$i", $hall);
        }

        $manager->flush();
    }
}

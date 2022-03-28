<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Producer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

final class ProducerFixtures extends Fixture
{
    public const NUMBER = 30;

    public function load(ObjectManager $manager): void
    {
        $generator = Factory::create();

        for ($i = 0; $i <= self::NUMBER; $i++) {
            $producer = new Producer();
            $producer->setName($generator->name);
            $manager->persist($producer);

            $this->addReference("producer_$i", $producer);
        }

        $manager->flush();
    }
}

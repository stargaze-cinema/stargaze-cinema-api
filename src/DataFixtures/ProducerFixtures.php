<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Producer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProducerFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $producer = new Producer();
        $producer->setName('John Fox');
        $manager->persist($producer);
        $this->addReference('producer_1', $producer);

        $producer = new Producer();
        $producer->setName('Evan You');
        $manager->persist($producer);
        $this->addReference('producer_2', $producer);

        $manager->flush();
    }
}

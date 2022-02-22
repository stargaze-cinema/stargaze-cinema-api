<?php

namespace App\DataFixtures;

use App\Entity\Producer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProducerFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $producer = new Producer();
        $producer->setName('Somebody');
        $manager->persist($producer);
        $this->addReference('producer_1', $producer);

        $producer = new Producer();
        $producer->setName('once told me');
        $manager->persist($producer);
        $this->addReference('producer_2', $producer);

        $manager->flush();
    }
}

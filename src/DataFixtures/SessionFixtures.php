<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Session;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class SessionFixtures extends Fixture implements DependentFixtureInterface
{
    const NUMBER = 60;

    public function load(ObjectManager $manager): void
    {
        $generator = Factory::create();

        for ($i = 0; $i <= self::NUMBER; $i++) {
            $session = new Session();
            $session->setBeginTime($generator->dateTime);
            $session->setEndTime($generator->dateTime->add(new \DateInterval('P2D')));
            $session->setMovie($this->getReference('movie_' . $generator->numberBetween(0, MovieFixtures::NUMBER)));
            $session->setHall($this->getReference('hall_' . $generator->numberBetween(0, HallFixtures::NUMBER)));
            $manager->persist($session);

            $this->addReference("session_$i", $session);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            MovieFixtures::class,
            HallFixtures::class
        ];
    }
}

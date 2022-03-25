<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Movie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class MovieFixtures extends Fixture implements DependentFixtureInterface
{
    const NUMBER = 20;

    public function load(ObjectManager $manager): void
    {
        $generator = Factory::create();
        for ($i = 0; $i <= self::NUMBER; $i++) {
            $movie = new Movie();
            $movie->setTitle($generator->words(2, true));
            $movie->setDescription($generator->realText());
            $movie->setPrice($generator->randomNumber(2));
            $movie->setYear($generator->numberBetween(1888, 2022));
            $movie->setDuration($generator->numberBetween(0, 300));
            $movie->setCategory($this->getReference('category_' . $generator->numberBetween(0, CategoryFixtures::NUMBER)));
            $movie->setProducer($this->getReference('producer_' . $generator->numberBetween(0, ProducerFixtures::NUMBER)));
            $manager->persist($movie);

            $this->addReference("movie_$i", $movie);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CategoryFixtures::class,
            ProducerFixtures::class
        ];
    }
}

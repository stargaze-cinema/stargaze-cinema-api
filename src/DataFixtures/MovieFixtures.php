<?php

namespace App\DataFixtures;

use App\Entity\Movie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class MovieFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $movie = new Movie();
        $movie->setTitle('Raya And The Last Dragon');
        $movie->setDescription('Watch Raya And The Last Dragon today!');
        $movie->setPrice(10.99);
        $movie->setYear(2021);
        $movie->setDuration(120);
        $movie->setProducer($this->getReference('producer_1'));
        $movie->setCategory($this->getReference('category_1'));
        $manager->persist($movie);

        $movie = new Movie();
        $movie->setTitle('Avengers: Endgame');
        $movie->setDescription('Watch Avengers: Endgam today!');
        $movie->setPrice(11.99);
        $movie->setYear(2019);
        $movie->setDuration(140);
        $movie->setProducer($this->getReference('producer_2'));
        $movie->setCategory($this->getReference('category_2'));
        $manager->persist($movie);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            'App\DataFixtures\CategoryFixtures',
            'App\DataFixtures\ProducerFixtures'
        ];
    }
}

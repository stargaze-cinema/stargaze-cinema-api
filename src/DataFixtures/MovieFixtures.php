<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Movie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

final class MovieFixtures extends Fixture implements DependentFixtureInterface
{
    public const NUMBER = 20;

    private $posters = [
        'https://cdn.discordapp.com/attachments/691374456513233036/959449815874424832/FFHNt85aMAEoqUL.png',
        'https://cdn.discordapp.com/attachments/691374456513233036/959449816176394310/FD_htaLacAEVWsb.jpg',
        'https://cdn.discordapp.com/attachments/691374456513233036/959449816545525770/FD5pZ9nacAENkv1.jpg',
        'https://cdn.discordapp.com/attachments/691374456513233036/959449816943976479/FF7LC_2UYAAqDme.png'
    ];

    public function load(ObjectManager $manager): void
    {
        $generator = Factory::create();

        $movie = new Movie();
        $movie->setTitle('Raya and the Last Dragon');
        $movie->setDescription('Long ago, in the fantasy world of Kumandra, humans and dragons lived
        together in harmony. However, when sinister monsters known as the Druun threatened the land,
        the dragons sacrificed themselves to save humanity. Now, 500 years later, those same monsters
        have returned, and it is up to a lone warrior to track down the last dragon and stop the
        Druun for good.');
        $movie->setPoster('https://media.comicbook.com/2021/03/sisu-poster-1261403.jpeg');
        $movie->setPrice(22.00);
        $movie->setYear(2021);
        $movie->setDuration(107);
        $movie->setCategory($this->getReference('category_0'));
        $movie->setProducer($this->getReference('producer_0'));
        $manager->persist($movie);
        $this->addReference("movie_0", $movie);

        for ($i = 1; $i <= self::NUMBER; $i++) {
            $movie = new Movie();
            $movie->setTitle($generator->words(2, true));
            $movie->setDescription($generator->realText());
            $movie->setPoster($this->posters[array_rand($this->posters)]);
            $movie->setPrice($generator->randomNumber(2));
            $movie->setYear($generator->numberBetween(1888, 2022));
            $movie->setDuration($generator->numberBetween(0, 300));
            $movie->setCategory($this->getReference('category_' .
                $generator->numberBetween(0, CategoryFixtures::NUMBER)));
            $movie->setProducer($this->getReference('producer_' .
                $generator->numberBetween(0, ProducerFixtures::NUMBER)));
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

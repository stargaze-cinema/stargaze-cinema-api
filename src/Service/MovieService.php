<?php

declare(strict_types=1);

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Movie;

class MovieService
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
    }

    public function saveMovie(
        string $title,
        string | null $description,
        string | null $poster,
        float $price,
        int $year,
        int $duration,
        string $category,
        string $producer
    ): Movie {
        $movie = new Movie();
        $movie->setTitle($title);
        $movie->setDescription($description);
        $movie->setPoster($poster);
        $movie->setPrice($price);
        $movie->setYear($year);
        $movie->setDuration($duration);
        $movie->setCategory(
            $this->entityManager->getRepository(\App\Entity\Category::class)->findOneBy(['name' => $category])
        );
        $movie->setProducer(
            $this->entityManager->getRepository(\App\Entity\Producer::class)->findOneBy(['name' => $producer])
        );

        $this->entityManager->persist($movie);
        $this->entityManager->flush();

        return $movie;
    }


    public function updateMovie(
        Movie $movie,
        string | null $title,
        string | null $description,
        string | null $poster,
        float | null $price,
        int | null $year,
        int | null $duration,
        string | null $category,
        string | null $producer
    ): Movie {
        if ($title) {
            $movie->setTitle($title);
        }
        if ($description) {
            $movie->setDescription($description);
        }
        if ($price) {
            $movie->setPrice($price);
        }
        if ($year) {
            $movie->setYear($year);
        }
        if ($poster) {
            $movie->setPoster($poster);
        }
        if ($duration) {
            $movie->setDuration($duration);
        }
        if ($category) {
            $categoryObj = $this->entityManager->getRepository(\App\Entity\Category::class)->findOneBy(['name' => $category]);
            if (!$categoryObj) {
                throw new \Exception("Selected category does not exist.");
            }
            $movie->setProducer($categoryObj);
        }
        if ($producer) {
            $producerObj = $this->entityManager->getRepository(\App\Entity\Producer::class)->findOneBy(['name' => $producer]);
            if (!$producerObj) {
                throw new \Exception("Selected producer does not exist.");
            }
            $movie->setProducer($producerObj);
        }

        $this->entityManager->persist($movie);
        $this->entityManager->flush();

        return $movie;
    }

    public function deleteMovie(Movie $movie): bool
    {
        $this->entityManager->remove($movie);
        $this->entityManager->flush();

        return true;
    }
}

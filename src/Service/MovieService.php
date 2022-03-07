<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Movie;
use Doctrine\ORM\EntityManagerInterface;
use App\Parameters\CreateMovieParameters;
use App\Parameters\UpdateMovieParameters;

class MovieService
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
    }

    public function saveMovie(CreateMovieParameters $params): Movie
    {
        $movie = new Movie();
        $movie->setTitle($params->getTitle());
        $movie->setDescription($params->getDescription());
        $movie->setPoster($params->getPoster());
        $movie->setPrice($params->getPrice());
        $movie->setYear($params->getYear());
        $movie->setDuration($params->getDuration());
        $movie->setCategory(
            $this->entityManager->getRepository(\App\Entity\Category::class)->findOneBy(['name' => $params->getCategory()])
        );
        $movie->setProducer(
            $this->entityManager->getRepository(\App\Entity\Producer::class)->findOneBy(['name' => $params->getProducer()])
        );

        $this->entityManager->persist($movie);
        $this->entityManager->flush();

        return $movie;
    }


    public function updateMovie(Movie $movie, UpdateMovieParameters $params): Movie
    {
        if ($title = $params->getTitle()) {
            $movie->setTitle($title);
        }
        if ($description = $params->getDescription()) {
            $movie->setDescription($description);
        }
        if ($price = $params->getPrice()) {
            $movie->setPrice($price);
        }
        if ($year = $params->getYear()) {
            $movie->setYear($year);
        }
        if ($poster = $params->getPoster()) {
            $movie->setPoster($poster);
        }
        if ($duration = $params->getDuration()) {
            $movie->setDuration($duration);
        }
        if ($category = $params->getCategory()) {
            $categoryObj = $this->entityManager->getRepository(\App\Entity\Category::class)->findOneBy(['name' => $category]);
            if (!$categoryObj) {
                throw new \Exception("Selected category does not exist.");
            }
            $movie->setProducer($categoryObj);
        }
        if ($producer = $params->getProducer()) {
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

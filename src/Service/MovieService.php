<?php

declare(strict_types=1);

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Movie;
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
        $movie->setTitle($params->title);
        $movie->setDescription($params->description);
        $movie->setPoster($params->poster);
        $movie->setPrice($params->price);
        $movie->setYear($params->year);
        $movie->setDuration($params->duration);
        $movie->setCategory(
            $this->entityManager->getRepository(\App\Entity\Category::class)->findOneBy(['name' => $params->category])
        );
        $movie->setProducer(
            $this->entityManager->getRepository(\App\Entity\Producer::class)->findOneBy(['name' => $params->producer])
        );

        $this->entityManager->persist($movie);
        $this->entityManager->flush();

        return $movie;
    }


    public function updateMovie(Movie $movie, UpdateMovieParameters $params): Movie
    {
        if ($params->title) {
            $movie->setTitle($params->title);
        }
        if ($params->description) {
            $movie->setDescription($params->description);
        }
        if ($params->price) {
            $movie->setPrice($params->price);
        }
        if ($params->year) {
            $movie->setYear($params->year);
        }
        if ($params->poster) {
            $movie->setPoster($params->poster);
        }
        if ($params->duration) {
            $movie->setDuration($params->duration);
        }
        if ($params->category) {
            $categoryObj = $this->entityManager->getRepository(\App\Entity\Category::class)->findOneBy(['name' => $params->category]);
            if (!$categoryObj) {
                throw new \Exception("Selected category does not exist.");
            }
            $movie->setProducer($categoryObj);
        }
        if ($params->producer) {
            $producerObj = $this->entityManager->getRepository(\App\Entity\Producer::class)->findOneBy(['name' => $params->producer]);
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

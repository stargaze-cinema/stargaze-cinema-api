<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Movie;
use App\Exception\NotExistsException;
use Doctrine\ORM\EntityManagerInterface;
use App\Parameters\CreateMovieParameters;
use App\Parameters\UpdateMovieParameters;

class MovieService
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
    }

    /**
     * @throws NotExistsException
     */
    public function save(CreateMovieParameters $params): Movie
    {
        $movie = new Movie();
        $movie->setTitle($params->getTitle());
        $movie->setDescription($params->getDescription());
        $movie->setPoster($params->getPoster());
        $movie->setPrice($params->getPrice());
        $movie->setYear($params->getYear());
        $movie->setDuration($params->getDuration());
        if (!$categoryEntity = $this->entityManager->getRepository(\App\Entity\Category::class)->find($params->getCategoryId())) {
            throw new NotExistsException("Selected category does not exist.");
        }
        $movie->setCategory($categoryEntity);
        if (!$producerEntity = $this->entityManager->getRepository(\App\Entity\Producer::class)->find($params->getProducerId())) {
            throw new NotExistsException("Selected producer does not exist.");
        }
        $movie->setProducer($producerEntity);

        $this->entityManager->persist($movie);
        $this->entityManager->flush();

        return $movie;
    }

    /**
     * @throws NotExistsException
     */
    public function update(Movie $movie, UpdateMovieParameters $params): Movie
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
        if ($category_id = $params->getCategoryId()) {
            if (!$categoryEntity = $this->entityManager->getRepository(\App\Entity\Category::class)->find($category_id)) {
                throw new NotExistsException("Selected category does not exist.");
            }
            $movie->setCategory($categoryEntity);
        }
        if ($producer_id = $params->getProducerId()) {
            if (!$producerEntity = $this->entityManager->getRepository(\App\Entity\Producer::class)->find($producer_id)) {
                throw new NotExistsException("Selected producer does not exist.");
            }
            $movie->setProducer($producerEntity);
        }

        $this->entityManager->persist($movie);
        $this->entityManager->flush();

        return $movie;
    }

    public function delete(Movie $movie): bool
    {
        $this->entityManager->remove($movie);
        $this->entityManager->flush();

        return true;
    }
}

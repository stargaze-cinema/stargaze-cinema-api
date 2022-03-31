<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Movie;
use App\Exception\NotExistsException;
use App\Parameters\CreateMovieParameters;
use App\Parameters\UpdateMovieParameters;

class MovieService extends AbstractEntityService
{
    /**
     * Creates new Movie from parameters or updates an existing by passing its entity
     *
     * @throws NotExistsException
     */
    public function create(CreateMovieParameters | UpdateMovieParameters $params, Movie $movie = new Movie()): Movie
    {
        if ($title = $params->getTitle()) {
            $movie->setTitle($title);
        }
        if ($description = $params->getDescription()) {
            $movie->setDescription($description);
        } else {
            $movie->setDescription(null);
        }
        if ($poster = $params->getPoster()) {
            $movie->setPoster($poster);
        } else {
            $movie->setPoster(null);
        }
        if ($price = $params->getPrice()) {
            $movie->setPrice($price);
        }
        if ($year = $params->getYear()) {
            $movie->setYear($year);
        }
        if ($duration = $params->getDuration()) {
            $movie->setDuration($duration);
        }
        if ($category_id = $params->getCategoryId()) {
            if (!$categoryEntity = $this->getEntityRepository(\App\Entity\Category::class)->find($category_id)) {
                throw new NotExistsException("Selected category does not exist.");
            }
            $movie->setCategory($categoryEntity);
        }
        if ($producer_id = $params->getProducerId()) {
            if (!$producerEntity = $this->getEntityRepository(\App\Entity\Producer::class)->find($producer_id)) {
                throw new NotExistsException("Selected producer does not exist.");
            }
            $movie->setProducer($producerEntity);
        }

        return $movie;
    }
}

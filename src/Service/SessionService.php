<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Session;
use App\Exception\NotExistsException;
use App\Parameters\CreateSessionParameters;
use App\Parameters\UpdateSessionParameters;

class SessionService extends AbstractEntityService
{
    /**
     * Creates new Session from parameters or updates an existing by passing its entity
     *
     * @throws NotExistsException
     */
    public function create(CreateSessionParameters | UpdateSessionParameters $params, Session $session = new Session()): Session
    {
        if ($beginAt = $params->getBeginAt()) {
            $session->setBeginAt($beginAt);
        }
        if ($endAt = $params->getEndAt()) {
            $session->setEndAt($endAt);
        }
        if ($movieId = $params->getMovieId()) {
            if (!$movieEntity = $this->getEntityRepository(\App\Entity\Movie::class)->find($movieId)) {
                throw new NotExistsException("Selected category does not exist.");
            }
            $session->setMovie($movieEntity);
        }
        if ($hallId = $params->getHallId()) {
            if (!$hallEntity = $this->getEntityRepository(\App\Entity\Hall::class)->find($hallId)) {
                throw new NotExistsException("Selected hall does not exist.");
            }
            $session->setHall($hallEntity);
        }

        return $session;
    }
}

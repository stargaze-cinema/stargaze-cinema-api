<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Session;
use App\Exception\NotExistsException;
use Doctrine\ORM\EntityManagerInterface;
use App\Parameters\CreateSessionParameters;
use App\Parameters\UpdateSessionParameters;

class SessionService
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
    }

    /**
     * @throws NotExistsException
     */
    public function save(CreateSessionParameters $params): Session
    {
        $session = new Session();
        $session->setBeginAt($params->getBeginAt());
        $session->setEndAt($params->getEndAt());
        if (!$movieEntity = $this->entityManager->getRepository(\App\Entity\Movie::class)->find($params->getMovieId())) {
            throw new NotExistsException("Selected category does not exist.");
        }
        $session->setMovie($movieEntity);
        if (!$hallEntity = $this->entityManager->getRepository(\App\Entity\Hall::class)->find($params->getHallId())) {
            throw new NotExistsException("Selected hall does not exist.");
        }
        $session->setHall($hallEntity);

        $this->entityManager->persist($session);
        $this->entityManager->flush();

        return $session;
    }

    /**
     * @throws NotExistsException
     */
    public function update(Session $session, UpdateSessionParameters $params): Session
    {
        if ($begin_at = $params->getBeginAt()) {
            $session->setBeginAt($begin_at);
        }
        if ($end_at = $params->getEndAt()) {
            $session->setEndAt($end_at);
        }
        if ($movieId = $params->getMovieId()) {
            if (!$movieEntity = $this->entityManager->getRepository(\App\Entity\Movie::class)->find($movieId)) {
                throw new NotExistsException("Selected movie does not exist.");
            }
            $session->setMovie($movieEntity);
        }
        if ($hallId = $params->getHallId()) {
            if (!$hallEntity = $this->entityManager->getRepository(\App\Entity\Hall::class)->find($hallId)) {
                throw new NotExistsException("Selected hall does not exist.");
            }
            $session->setHall($hallEntity);
        }

        $this->entityManager->persist($session);
        $this->entityManager->flush();

        return $session;
    }

    public function delete(Session $session): bool
    {
        $this->entityManager->remove($session);
        $this->entityManager->flush();

        return true;
    }
}

<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Session;
use Doctrine\ORM\EntityManagerInterface;
use App\Parameters\CreateSessionParameters;
use App\Parameters\UpdateSessionParameters;

class SessionService
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
    }

    public function save(CreateSessionParameters $params): Session
    {
        $session = new Session();
        $session->setBeginTime($params->getBeginTime());
        $session->setEndTime($params->getEndTime());
        if (!$movieClass = $this->entityManager->getRepository(\App\Entity\Movie::class)->find($params->getMovieId())) {
            throw new \Exception("Selected category does not exist.");
        }
        $session->setMovie($movieClass);
        if (!$hallClass = $this->entityManager->getRepository(\App\Entity\Hall::class)->find($params->getHallId())) {
            throw new \Exception("Selected hall does not exist.");
        }
        $session->setHall($hallClass);

        $this->entityManager->persist($session);
        $this->entityManager->flush();

        return $session;
    }


    public function update(Session $session, UpdateSessionParameters $params): Session
    {
        if ($begin_at = $params->getBeginTime()) {
            $session->setBeginTime($begin_at);
        }
        if ($end_at = $params->getEndTime()) {
            $session->setEndTime($end_at);
        }
        if ($movieId = $params->getMovieId()) {
            if (!$movieClass = $this->entityManager->getRepository(\App\Entity\Movie::class)->find($movieId)) {
                throw new \Exception("Selected movie does not exist.");
            }
            $session->setMovie($movieClass);
        }
        if ($hallId = $params->getHallId()) {
            if (!$hallClass = $this->entityManager->getRepository(\App\Entity\Hall::class)->find($hallId)) {
                throw new \Exception("Selected hall does not exist.");
            }
            $session->setHall($hallClass);
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

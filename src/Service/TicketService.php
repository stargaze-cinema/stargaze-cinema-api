<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Ticket;
use App\Exception\NotExistsException;
use Doctrine\ORM\EntityManagerInterface;
use App\Parameters\CreateTicketParameters;
use App\Parameters\UpdateTicketParameters;

class TicketService
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
    }

    /**
     * @throws NotExistsException
     */
    public function save(CreateTicketParameters $params): Ticket
    {
        $ticket = new Ticket();
        $ticket->setPlace($params->getPlace());
        if (!$userEntity = $this->entityManager->getRepository(\App\Entity\User::class)->find($params->getUserId())) {
            throw new NotExistsException("Selected user does not exist.");
        }
        $ticket->setUser($userEntity);
        if (!$sessionEntity = $this->entityManager->getRepository(\App\Entity\Session::class)->find($params->getSessionId())) {
            throw new NotExistsException("Selected session does not exist.");
        }
        $ticket->setSession($sessionEntity);

        $this->entityManager->persist($ticket);
        $this->entityManager->flush();

        return $ticket;
    }

    /**
     * @throws NotExistsException
     */
    public function update(Ticket $ticket, UpdateTicketParameters $params): Ticket
    {
        if ($place = $params->getPlace()) {
            $ticket->setPlace($place);
        }
        if ($user_id = $params->getUserId()) {
            if (!$userEntity = $this->entityManager->getRepository(\App\Entity\User::class)->find($user_id)) {
                throw new NotExistsException("Selected user does not exist.");
            }
            $ticket->setUser($userEntity);
        }
        if ($session_id = $params->getSessionId()) {
            if (!$sessionEntity = $this->entityManager->getRepository(\App\Entity\Session::class)->find($session_id)) {
                throw new NotExistsException("Selected session does not exist.");
            }
            $ticket->setSession($sessionEntity);
        }

        $this->entityManager->persist($ticket);
        $this->entityManager->flush();

        return $ticket;
    }

    public function delete(Ticket $ticket): bool
    {
        $this->entityManager->remove($ticket);
        $this->entityManager->flush();

        return true;
    }
}

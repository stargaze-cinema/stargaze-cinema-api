<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Ticket;
use Doctrine\ORM\EntityManagerInterface;
use App\Parameters\CreateTicketParameters;
use App\Parameters\UpdateTicketParameters;

class TicketService
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
    }

    public function save(CreateTicketParameters $params): Ticket
    {
        $ticket = new Ticket();
        $ticket->setPlace($params->getPlace());
        if (!$userClass = $this->entityManager->getRepository(\App\Entity\User::class)->find($params->getUserId())) {
            throw new \Exception("Selected user does not exist.");
        }
        $ticket->setUser($userClass);
        if (!$sessionClass = $this->entityManager->getRepository(\App\Entity\Session::class)->find($params->getSessionId())) {
            throw new \Exception("Selected session does not exist.");
        }
        $ticket->setSession($sessionClass);

        $this->entityManager->persist($ticket);
        $this->entityManager->flush();

        return $ticket;
    }


    public function update(Ticket $ticket, UpdateTicketParameters $params): Ticket
    {
        if ($place = $params->getPlace()) {
            $ticket->setPlace($place);
        }
        if ($user_id = $params->getUserId()) {
            if (!$userClass = $this->entityManager->getRepository(\App\Entity\User::class)->find($user_id)) {
                throw new \Exception("Selected user does not exist.");
            }
            $ticket->setUser($userClass);
        }
        if ($session_id = $params->getSessionId()) {
            if (!$sessionClass = $this->entityManager->getRepository(\App\Entity\Session::class)->find($session_id)) {
                throw new \Exception("Selected session does not exist.");
            }
            $ticket->setSession($sessionClass);
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

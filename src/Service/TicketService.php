<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Ticket;
use App\Exception\NotExistsException;
use App\Parameters\CreateTicketParameters;
use App\Parameters\UpdateTicketParameters;

class TicketService extends AbstractEntityService
{
    /**
     * Creates new Ticket from parameters or updates an existing by passing its entity
     *
     * @throws NotExistsException
     */
    public function create(
        CreateTicketParameters | UpdateTicketParameters $params,
        Ticket $ticket = new Ticket()
    ): Ticket {
        if ($place = $params->getPlace()) {
            $ticket->setPlace($place);
        }
        if ($user_id = $params->getUserId()) {
            if (!$userEntity = $this->getEntityRepository(\App\Entity\User::class)->find($user_id)) {
                throw new NotExistsException("Selected user does not exist.");
            }
            $ticket->setUser($userEntity);
        }
        if ($session_id = $params->getSessionId()) {
            if (!$sessionEntity = $this->getEntityRepository(\App\Entity\Session::class)->find($session_id)) {
                throw new NotExistsException("Selected session does not exist.");
            }
            $ticket->setSession($sessionEntity);
        }

        return $ticket;
    }
}

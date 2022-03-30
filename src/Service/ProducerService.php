<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Producer;
use App\Parameters\CreateProducerParameters;
use App\Parameters\UpdateProducerParameters;

class ProducerService extends AbstractEntityService
{
    /**
     * Creates new Producer from parameters or updates an existing by passing its entity
     *
     * @throws NotExistsException
     */
    public function create(CreateProducerParameters | UpdateProducerParameters $params, Producer $producer = new Producer()): Producer
    {
        if ($name = $params->getName()) {
            $producer->setName($name);
        }

        return $producer;
    }
}

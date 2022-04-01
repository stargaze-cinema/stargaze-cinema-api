<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Hall;
use App\Parameters\CreateHallParameters;
use App\Parameters\UpdateHallParameters;

class HallService extends AbstractEntityService
{
    /**
     * Creates new Hall from parameters or updates an existing by passing its entity
     */
    public function create(CreateHallParameters | UpdateHallParameters $params, Hall $hall = new Hall()): Hall
    {
        if ($name = $params->getName()) {
            $hall->setName($name);
        }
        if ($capacity = $params->getCapacity()) {
            $hall->setCapacity($capacity);
        }
        if ($type = $params->getType()) {
            $hall->setType($type);
        }

        return $hall;
    }
}

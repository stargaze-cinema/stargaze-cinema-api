<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Hall;
use Doctrine\ORM\EntityManagerInterface;
use App\Parameters\CreateHallParameters;
use App\Parameters\UpdateHallParameters;

class HallService
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
    }

    public function save(CreateHallParameters $params): Hall
    {
        $movie = new Hall();
        $movie->setName($params->getName());
        $movie->setCapacity($params->getCapacity());
        $movie->setType($params->getType());

        $this->entityManager->persist($movie);
        $this->entityManager->flush();

        return $movie;
    }


    public function update(Hall $hall, UpdateHallParameters $params): Hall
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

        $this->entityManager->persist($hall);
        $this->entityManager->flush();

        return $hall;
    }

    public function delete(Hall $hall): bool
    {
        $this->entityManager->remove($hall);
        $this->entityManager->flush();

        return true;
    }
}

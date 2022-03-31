<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Producer;
use Doctrine\ORM\EntityManagerInterface;
use App\Parameters\CreateProducerParameters;
use App\Parameters\UpdateProducerParameters;

class ProducerService
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
    }

    public function save(CreateProducerParameters $params): Producer
    {
        $movie = new Producer();
        $movie->setName($params->getName());

        $this->entityManager->persist($movie);
        $this->entityManager->flush();

        return $movie;
    }

    public function update(Producer $producer, UpdateProducerParameters $params): Producer
    {
        if ($name = $params->getName()) {
            $producer->setName($name);
        }

        $this->entityManager->persist($producer);
        $this->entityManager->flush();

        return $producer;
    }

    public function delete(Producer $producer): bool
    {
        $this->entityManager->remove($producer);
        $this->entityManager->flush();

        return true;
    }
}

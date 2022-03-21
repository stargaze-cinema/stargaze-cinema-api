<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Movie;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Movie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Movie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Movie[]    findAll()
 * @method Movie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MovieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Movie::class);
    }

    public function findAllWithQuery(array $params): array
    {
        if (!$params) {
            return $this->findAll();
        }

        $matchedParams = false;
        $qb = $this->createQueryBuilder('movie');
        foreach ($params as $param => $value) {
            if (!$this->getClassMetadata()->hasField($param)) {
                continue;
            }
            $matchedParams = true;

            if ($this->getClassMetadata()->getTypeOfField($param) === 'string') {
                $qb->andWhere($qb->expr()->like("movie.$param", ":value"))
                    ->setParameter('value', "%$value%");
            } else {
                $qb->andWhere($qb->expr()->eq("movie.$param", ":value"))
                    ->setParameter('value', $value);
            }
        }

        if (!$matchedParams) {
            return $this->findAll();
        }

        return $qb->getQuery()->getResult();
    }
}

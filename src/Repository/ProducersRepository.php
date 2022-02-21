<?php

namespace App\Repository;

use App\Entity\Producers;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Producers|null find($id, $lockMode = null, $lockVersion = null)
 * @method Producers|null findOneBy(array $criteria, array $orderBy = null)
 * @method Producers[]    findAll()
 * @method Producers[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProducersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Producers::class);
    }

    // /**
    //  * @return Producers[] Returns an array of Producers objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Producers
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

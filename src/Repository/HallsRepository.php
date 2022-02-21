<?php

namespace App\Repository;

use App\Entity\Halls;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Halls|null find($id, $lockMode = null, $lockVersion = null)
 * @method Halls|null findOneBy(array $criteria, array $orderBy = null)
 * @method Halls[]    findAll()
 * @method Halls[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HallsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Halls::class);
    }

    // /**
    //  * @return Halls[] Returns an array of Halls objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('h.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Halls
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

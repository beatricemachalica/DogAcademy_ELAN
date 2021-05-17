<?php

namespace App\Repository;

use App\Entity\Chien;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Chien|null find($id, $lockMode = null, $lockVersion = null)
 * @method Chien|null findOneBy(array $criteria, array $orderBy = null)
 * @method Chien[]    findAll()
 * @method Chien[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChienRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Chien::class);
    }

    // /**
    //  * @return Chien[] Returns an array of Chien objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Chien
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

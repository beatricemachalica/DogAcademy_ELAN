<?php

namespace App\Repository;

use App\Entity\Session;
use App\Data\SearchData;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Session|null find($id, $lockMode = null, $lockVersion = null)
 * @method Session|null findOneBy(array $criteria, array $orderBy = null)
 * @method Session[]    findAll()
 * @method Session[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SessionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Session::class);
    }

    /**
     * @return Session[]
     */
    public function findSearch(SearchData $search): array
    {
        $query = $this
            ->createQueryBuilder('p');
        if (!empty($search->q)) {
            $query = $query
                ->andWhere('p.formation LIKE :q')
                ->setParameter('q', "%{$search->q}%");
        }
        if (!empty($search->formations)) {
            $query = $query
                ->andWhere('c.id IN :formations')
                ->setParameter('formations', $search->formations);
        }
        return $query->getQuery()->getResult();
    }
}

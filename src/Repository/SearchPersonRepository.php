<?php

namespace App\Repository;

use App\Entity\SearchPerson;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method SearchPerson|null find($id, $lockMode = null, $lockVersion = null)
 * @method SearchPerson|null findOneBy(array $criteria, array $orderBy = null)
 * @method SearchPerson[]    findAll()
 * @method SearchPerson[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SearchPersonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SearchPerson::class);
    }

    // /**
    //  * @return SearchPerson[] Returns an array of SearchPerson objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SearchPerson
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

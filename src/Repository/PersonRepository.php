<?php

namespace App\Repository;

use App\Entity\Person;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * @method Person|null find($id, $lockMode = null, $lockVersion = null)
 * @method Person|null findOneBy(array $criteria, array $orderBy = null)
 * @method Person[]    findAll()
 * @method Person[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PersonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Person::class);
    }


    /**
     * @param string $country
     * @return array
     */
    public function findAllByCountry($country = '') : array
    {
        $query = $this->createQueryBuilder('p')
            ->orderBy('p.nationality', 'ASC');

        if(!empty($country->getNationality())){
            $query->andWhere('p.nationality = :val')
                ->setParameter('val', $country->getNationality());
        }

        return $query->getQuery()->getResult();
    }


}

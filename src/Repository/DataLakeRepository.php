<?php

namespace App\Repository;

use App\Entity\DataLake;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method DataLake|null find($id, $lockMode = null, $lockVersion = null)
 * @method DataLake|null findOneBy(array $criteria, array $orderBy = null)
 * @method DataLake[]    findAll()
 * @method DataLake[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DataLakeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DataLake::class);
    }

    // /**
    //  * @return DataLake[] Returns an array of DataLake objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DataLake
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

<?php

namespace App\Repository;

use App\Entity\WebhookUrlPairs;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method WebhookUrlPairs|null find($id, $lockMode = null, $lockVersion = null)
 * @method WebhookUrlPairs|null findOneBy(array $criteria, array $orderBy = null)
 * @method WebhookUrlPairs[]    findAll()
 * @method WebhookUrlPairs[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WebhookUrlPairsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WebhookUrlPairs::class);
    }

    // /**
    //  * @return WebhookUrlPairs[] Returns an array of WebhookUrlPairs objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('w.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?WebhookUrlPairs
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

<?php

namespace App\Repository;

use App\Entity\MessageHistory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MessageHistory>
 *
 * @method MessageHistory|null find($id, $lockMode = null, $lockVersion = null)
 * @method MessageHistory|null findOneBy(array $criteria, array $orderBy = null)
 * @method MessageHistory[]    findAll()
 * @method MessageHistory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MessageHistoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MessageHistory::class);
    }

    //    /**
    //     * @return MessageHistory[] Returns an array of MessageHistory objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('m.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?MessageHistory
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}

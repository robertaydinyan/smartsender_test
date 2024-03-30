<?php

namespace App\Repository;

use App\Entity\ChannelCustomers;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ChannelCustomers>
 *
 * @method ChannelCustomers|null find($id, $lockMode = null, $lockVersion = null)
 * @method ChannelCustomers|null findOneBy(array $criteria, array $orderBy = null)
 * @method ChannelCustomers[]    findAll()
 * @method ChannelCustomers[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChannelCustomersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ChannelCustomers::class);
    }

    //    /**
    //     * @return ChannelCustomers[] Returns an array of ChannelCustomers objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?ChannelCustomers
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}

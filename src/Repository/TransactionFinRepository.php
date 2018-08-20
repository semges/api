<?php

namespace App\Repository;

use App\Entity\TransactionFin;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TransactionFin|null find($id, $lockMode = null, $lockVersion = null)
 * @method TransactionFin|null findOneBy(array $criteria, array $orderBy = null)
 * @method TransactionFin[]    findAll()
 * @method TransactionFin[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TransactionFinRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TransactionFin::class);
    }

//    /**
//     * @return TransactionFin[] Returns an array of TransactionFin objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TransactionFin
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

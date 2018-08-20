<?php

namespace App\Repository;

use App\Entity\Prevision;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Prevision|null find($id, $lockMode = null, $lockVersion = null)
 * @method Prevision|null findOneBy(array $criteria, array $orderBy = null)
 * @method Prevision[]    findAll()
 * @method Prevision[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PrevisionRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Prevision::class);
    }

//    /**
//     * @return Prevision[] Returns an array of Prevision objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Prevision
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

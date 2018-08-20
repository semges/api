<?php

namespace App\Repository;

use App\Entity\AnonymeField;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method AnonymeField|null find($id, $lockMode = null, $lockVersion = null)
 * @method AnonymeField|null findOneBy(array $criteria, array $orderBy = null)
 * @method AnonymeField[]    findAll()
 * @method AnonymeField[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnonymeFieldRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, AnonymeField::class);
    }

//    /**
//     * @return AnonymeField[] Returns an array of AnonymeField objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AnonymeField
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

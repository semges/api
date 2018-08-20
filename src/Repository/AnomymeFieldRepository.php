<?php

namespace App\Repository;

use App\Entity\AnomymeField;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method AnomymeField|null find($id, $lockMode = null, $lockVersion = null)
 * @method AnomymeField|null findOneBy(array $criteria, array $orderBy = null)
 * @method AnomymeField[]    findAll()
 * @method AnomymeField[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnomymeFieldRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, AnomymeField::class);
    }

//    /**
//     * @return AnomymeField[] Returns an array of AnomymeField objects
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
    public function findOneBySomeField($value): ?AnomymeField
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

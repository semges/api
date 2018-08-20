<?php

namespace App\Repository;

use App\Entity\DetailProgram;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method DetailProgram|null find($id, $lockMode = null, $lockVersion = null)
 * @method DetailProgram|null findOneBy(array $criteria, array $orderBy = null)
 * @method DetailProgram[]    findAll()
 * @method DetailProgram[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DetailProgramRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, DetailProgram::class);
    }

//    /**
//     * @return DetailProgram[] Returns an array of DetailProgram objects
//     */
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
    public function findOneBySomeField($value): ?DetailProgram
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

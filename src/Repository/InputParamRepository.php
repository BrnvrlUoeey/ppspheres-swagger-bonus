<?php

namespace App\Repository;

use App\Entity\InputParam;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method InputParam|null find($id, $lockMode = null, $lockVersion = null)
 * @method InputParam|null findOneBy(array $criteria, array $orderBy = null)
 * @method InputParam[]    findAll()
 * @method InputParam[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InputParamRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, InputParam::class);
    }

    // /**
    //  * @return InputParam[] Returns an array of InputParam objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?InputParam
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

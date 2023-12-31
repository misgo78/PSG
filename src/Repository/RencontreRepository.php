<?php

namespace App\Repository;

use App\Entity\Rencontre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Rencontre|null find($id, $lockMode = null, $lockVersion = null)
 * @method Rencontre|null findOneBy(array $criteria, array $orderBy = null)
 * @method Rencontre[]    findAll()
 * @method Rencontre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RencontreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Rencontre::class);
    }

    public function findDernieresRencontres($aujourdhui, $limit)
    {
        return $this->createQueryBuilder('r')
            ->where('r.dateRencontre < :aujourdhui')
            ->setParameter('aujourdhui', $aujourdhui)
            ->orderBy('r.dateRencontre', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }
    
    public function findProchainesRencontres($aujourdhui, $limit)
    {
        return $this->createQueryBuilder('r')
            ->where('r.dateRencontre > :aujourdhui')
            ->setParameter('aujourdhui', $aujourdhui)
            ->orderBy('r.dateRencontre', 'ASC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    

    // /**
    //  * @return Rencontre[] Returns an array of Rencontre objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Rencontre
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

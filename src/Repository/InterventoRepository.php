<?php

namespace App\Repository;

use App\Entity\Intervento;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Intervento|null find($id, $lockMode = null, $lockVersion = null)
 * @method Intervento|null findOneBy(array $criteria, array $orderBy = null)
 * @method Intervento[]    findAll()
 * @method Intervento[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InterventoRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Intervento::class);
    }

//    /**
//     * @return Intervento[] Returns an array of Intervento objects
//     */
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
    public function findOneBySomeField($value): ?Intervento
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

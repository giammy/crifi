<?php

namespace App\Repository;

use App\Entity\Mezzo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Mezzo|null find($id, $lockMode = null, $lockVersion = null)
 * @method Mezzo|null findOneBy(array $criteria, array $orderBy = null)
 * @method Mezzo[]    findAll()
 * @method Mezzo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MezzoRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Mezzo::class);
    }

//    /**
//     * @return Mezzo[] Returns an array of Mezzo objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Mezzo
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

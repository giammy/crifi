<?php

namespace App\Repository;

use App\Entity\Equipaggio;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Equipaggio|null find($id, $lockMode = null, $lockVersion = null)
 * @method Equipaggio|null findOneBy(array $criteria, array $orderBy = null)
 * @method Equipaggio[]    findAll()
 * @method Equipaggio[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EquipaggioRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Equipaggio::class);
    }

//    /**
//     * @return Equipaggio[] Returns an array of Equipaggio objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Equipaggio
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

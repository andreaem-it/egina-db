<?php

namespace App\Repository;

use App\Entity\Articoli;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Articoli|null find($id, $lockMode = null, $lockVersion = null)
 * @method Articoli|null findOneBy(array $criteria, array $orderBy = null)
 * @method Articoli[]    findAll()
 * @method Articoli[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticoliRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Articoli::class);
    }

    // /**
    //  * @return Articoli[] Returns an array of Articoli objects
    //  */
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
    public function findOneBySomeField($value): ?Articoli
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

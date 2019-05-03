<?php

namespace App\Repository;

use App\Entity\Prestiti;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Prestiti|null find($id, $lockMode = null, $lockVersion = null)
 * @method Prestiti|null findOneBy(array $criteria, array $orderBy = null)
 * @method Prestiti[]    findAll()
 * @method Prestiti[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PrestitiRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Prestiti::class);
    }

    // /**
    //  * @return Prestiti[] Returns an array of Prestiti objects
    //  */
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
    public function findOneBySomeField($value): ?Prestiti
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

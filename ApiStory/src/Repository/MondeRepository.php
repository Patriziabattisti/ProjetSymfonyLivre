<?php

namespace App\Repository;

use App\Entity\Monde;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Monde|null find($id, $lockMode = null, $lockVersion = null)
 * @method Monde|null findOneBy(array $criteria, array $orderBy = null)
 * @method Monde[]    findAll()
 * @method Monde[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MondeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Monde::class);
    }

    // /**
    //  * @return Monde[] Returns an array of Monde objects
    //  */
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
    public function findOneBySomeField($value): ?Monde
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

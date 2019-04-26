<?php

namespace App\Repository;

use App\Entity\Auteur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Auteur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Auteur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Auteur[]    findAll()
 * @method Auteur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AuteurRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Auteur::class);
    }

    // /**
    //  * @return Auteur[] Returns an array of Auteur objects
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
    public function findOneBySomeField($value): ?Auteur
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function miseAjour(Auteur $nouvauteur, Auteur $monauteur){
        
      
        if($nouvauteur->getNom()!=null){
            $monauteur->setNom($nouvauteur->getNom());
        }
        if($nouvauteur->getPrenom()!=null){
            $monauteur->setPrenom($nouvauteur->getPrenom());
        }
        if($nouvauteur->getPhoto()!=null){
            $fichier=$nouvauteur->getPhoto();
            $photo= md5(uniqid()).".".$fichier->guessExtension();
            
            $fichier->move("photos",$photo);
            $monauteur->setPhoto($photo);
        }
        if($nouvauteur->getBibliographie()!=null){
            $monauteur->setBibliographie($nouvauteur->getBibliographie());
        }
        
        
        return $monauteur;
        
    }
}

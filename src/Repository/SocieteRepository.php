<?php

namespace App\Repository;

use App\Entity\Societe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Societe|null find($id, $lockMode = null, $lockVersion = null)
 * @method Societe|null findOneBy(array $criteria, array $orderBy = null)
 * @method Societe[]    findAll()
 * @method Societe[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SocieteRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Societe::class);
    }


    /**
    * @return Societe[] Returns an array of Societe objects
    */

    public function getSociete($id)
    {
        return $this->createQueryBuilder('s')
            ->join('s.utilisateurs', 'u')
            ->where('u.id = :val')
            ->setParameter('val', $id)
            ->getQuery()
            ->getResult();
        
    }


    public function getSocieteForm($id)
    {
        return $this->createQueryBuilder('s')
            ->join('s.utilisateurs', 'u')
            ->where('u.id = :val')
            ->setParameter('val', $id)
            ;
    }

     /**
//    * @return Societe[] Returns an array of Societe objects
//    */

    public function getSocietePrincipale($id)
    {
        return $this->createQueryBuilder('s')
            ->join('s.utilisateurs', 'u')
            ->where('s.isSocietePrincipale = :valPrincipale')
            ->andWhere('u.id = :valId')
            ->setParameter('valPrincipale', 1)
            ->setParameter('valId', $id)
            ->getQuery()
            ->getOneOrNullResult();
            // ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
    }









    
//    /**
//     * @return Societe[] Returns an array of Societe objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Societe
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

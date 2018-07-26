<?php

namespace App\Repository;

use App\Entity\Utilisateur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Utilisateur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Utilisateur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Utilisateur[]    findAll()
 * @method Utilisateur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UtilisateurRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Utilisateur::class);
    }


    public function getUtilisateurSociete($id)
    {
        return $this->createQueryBuilder('u')
            ->join('u.societes', 's')
            ->where('s.id = :val')
            ->setParameter('val', $id)
            ->getQuery()
            ->getResult();
            ;
    }


    public function getUtilisateurForm($id)
    {
        return $this->createQueryBuilder('u')
            ->join('u.societes', 's')
            ->where('s.id = :val')
            ->setParameter('val', $id)
            ;
    }


    public function getUtilisateurFils($id)
    {
        return $this->createQueryBuilder('u')
            ->where('u.idParent = :val')
            ->setParameter('val', $id)
            ;
    }



    public function countUtilisateurFils($id)
    {
        return $this->createQueryBuilder('u')
            ->select('count(u)')
            ->where('u.idParent = :val')
            ->setParameter('val', $id)
            ->getQuery()
            ->getSingleScalarResult()
            ;
    }







   

//    /**
//     * @return Utilisateur[] Returns an array of Utilisateur objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Utilisateur
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

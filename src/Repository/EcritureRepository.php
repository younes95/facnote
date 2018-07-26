<?php

namespace App\Repository;

use App\Entity\Ecriture;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Ecriture|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ecriture|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ecriture[]    findAll()
 * @method Ecriture[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EcritureRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Ecriture::class);
    }

     public function findAllNumeroCompte()
    {
        return $this->getEntityManager()->createQuery("Select distinct e.numeroCompte FROM App:Ecriture e")
            ->getResult()
        ;
    }


//    /**
//     * @return Ecriture[] Returns an array of Ecriture objects
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
    public function findOneBySomeField($value): ?Ecriture
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

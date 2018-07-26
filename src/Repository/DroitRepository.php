<?php

namespace App\Repository;

use App\Entity\Droit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Droit|null find($id, $lockMode = null, $lockVersion = null)
 * @method Droit|null findOneBy(array $criteria, array $orderBy = null)
 * @method Droit[]    findAll()
 * @method Droit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DroitRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Droit::class);
    }

    public function findDroit($idUtilisateur, $idSociete, $controllerNom)
    {
        if( $idSociete == 0) {
            $droit =  $this->createQueryBuilder('d')
            ->select('d.lectureEcritureSuppression, d.SeulTous')
            ->andWhere('d.utilisateurId = :valutilisateur')
            ->andWhere('d.moduleID = :valcontrollerNom')

            ->setParameter('valutilisateur', $idUtilisateur)
            ->setParameter('valcontrollerNom', $controllerNom)


            ->getQuery()
            ->getArrayResult()
            ;
        } else {
            $droit =  $this->createQueryBuilder('d')
              //  ->select('COUNT(d.id)')
                ->select('d.lectureEcritureSuppression, d.SeulTous')
                ->andWhere('d.utilisateurId = :valutilisateur')
                ->andWhere('d.SocieteId = :valSociete')
                ->andWhere('d.moduleID = :valcontrollerNom')

                ->setParameter('valutilisateur', $idUtilisateur)
                ->setParameter('valSociete', $idSociete)
                ->setParameter('valcontrollerNom', $controllerNom)


                ->getQuery()
                ->getArrayResult()
            ;
        }
         

        if (count($droit) == 0) {
            $droit[0]['lectureEcritureSuppression'] = 0;
            $droit[0]['SeulTous'] = 0;
        }


        return $droit;
    }



    


//    /**
//     * @return Droit[] Returns an array of Droit objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Droit
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

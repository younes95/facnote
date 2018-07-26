<?php

namespace App\Controller;

use App\Entity\Droit;
use App\Entity\Societe;
use App\Entity\Utilisateur;

use App\Form\EditerDroitType;
use App\Form\EditerDroitMassType;

use App\Entity\Module;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;



/** @Route("/droit") */

class DroitController extends Controller
{

	public function aDroitTwig($idUtilisateur, $idSociete, $controllerId, $tokenSociete, $RaisonSocial)
    {
        $entitymanager = $this->getDoctrine()->getManager();
        $droit = $entitymanager->getRepository(Droit::class)->findDroit($idUtilisateur, $idSociete, $controllerId);
        $nbDroit = $droit[0]['lectureEcritureSuppression'].$droit[0]['SeulTous'];
        if($nbDroit == 1) $nbDroit = 10;
        elseif($nbDroit == 2) $nbDroit = 20;
        elseif($nbDroit == 3) $nbDroit = 30;


        return $this->render('droit/nbdroit.html.twig', [
            'valeurDroit' => $nbDroit,
            'tokenSociete' => $tokenSociete,
            'RaisonSocial' => $RaisonSocial,
        ]);
    }


    public function aDroit($idUtilisateur, $idSociete, $controllerId)
    {
        $entitymanager = $this->getDoctrine()->getManager();
        $droit = $entitymanager->getRepository(Droit::class)->findDroit($idUtilisateur, $idSociete, $controllerId);
       /* switch($droit[0]['lectureEcritureSuppression'])
        {
            case 3:
                $nbDroit['lecture'] = true;
                $nbDroit['modification'] = true;
                $nbDroit['admin'] = true;
                $nbDroit['bloque'] = false;
            break;

            case 2:
                $nbDroit['lecture'] = true;
                $nbDroit['modification'] = true;
                $nbDroit['admin'] = false;
                $nbDroit['bloque'] = false;
            break;

            case 1:
                $nbDroit['lecture'] = true;
                $nbDroit['modification'] = false;
                $nbDroit['admin'] = false;
                $nbDroit['bloque'] = false;
            break;

            default:
                $nbDroit['lecture'] = false;
                $nbDroit['modification'] = false;
                $nbDroit['admin'] = false;
                $nbDroit['bloque'] = true;
            break;

        }
        switch($droit[0]['SeulTous'])
        {
        
            case 1:
                $nbDroit['tous'] = true;
            break;

            default:
                $nbDroit['tous'] = false;
            break;

        }*/

        $nbDroit = $droit[0]['lectureEcritureSuppression'].$droit[0]['SeulTous'];
        if($nbDroit == 1) $nbDroit = 10;
        elseif($nbDroit == 2) $nbDroit = 20;
        elseif($nbDroit == 3) $nbDroit = 30;
        return $nbDroit;
    }


    /**
     * @Route("/{tokenUtilisateurChercher}/{tokenSocieteChercher}/editer", methods={"GET", "POST"}, name="editer_droit_utilisateur")
     * @Security("has_role('ROLE_EDITION')")
     */

    public function editer(Request $request, $tokenUtilisateurChercher, $tokenSocieteChercher): Response
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(Utilisateur::class)->findOneBy(['tokenUtilisateur'=>$tokenUtilisateurChercher]);
        $idUtilisateur = $user->getId();
        $societe = $em->getRepository(Societe::class)->findOneBy(['tokenSociete'=>$tokenSocieteChercher]);
        $idSociete = $societe->getId();
        $droits = array('droits' => $em->getRepository(Droit::class)->findBy([
            'utilisateurId' => $idUtilisateur,
            'SocieteId' => $idSociete,
        ]));
        $form = $this->createForm(EditerDroitType::class, $droits);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
             // remettre les droits du gérant
            $this->droitGerant($idSociete);
            // fin droit gérant
            $this->addFlash('success', 'le compte à bien été modifié.');
          //  return $this->redirectToRoute('admin_post_edit', ['id' => $post->getId()]);
        }
        return $this->render('droit/editer.html.twig', [
            'form' => $form->createView(), 
            'nomsociete'=>$societe->getRaisonSocial(),
            'mainNavRegistration' => true, 
            'title' => $user->getNomUtilisateur().' '.$user->getPrenomUtilisateur(),
        ]);
    }

    /**
     * @Route("/{tokenUtilisateurChercher}/editermasssociete", methods={"GET", "POST"}, name="editer_droit_utilisateur_mass_societe")
     */

    public function editermasssociete(Request $request, $tokenUtilisateurChercher): Response
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(Utilisateur::class)->findOneBy(['tokenUtilisateur'=>$tokenUtilisateurChercher]);
        $idUtilisateur = $user->getId();        
        $droits = array('droits' => $em->getRepository(Droit::class)->findBy([
            'utilisateurId' => $idUtilisateur,
        ]));
        $modules = array('modules' => $em->getRepository(Module::class)
                    ->createQueryBuilder('m')
                        ->select('m')
                        ->getQuery()
                        ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY));
        $form = $this->createForm(EditerDroitMassType::class, $modules);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $em->getRepository(Utilisateur::class)->findOneBy(['tokenUtilisateur'=>$tokenUtilisateurChercher]);
            $idUtilisateur = $user->getId();
            $droits = $em->getRepository(Droit::class)->findBy(['utilisateurId'=>$idUtilisateur]);
            foreach ($droits as $droitaEffacer) {
                $em->remove($droitaEffacer);
            }
            $em->flush();          
             $data = $form->getData();
             $societes = $em->getRepository(Societe::class)
                    ->createQueryBuilder('s')
                    ->select('s.id')
                    ->join('s.utilisateurs', 'u')
                    ->where('u.id = :val')
                    ->setParameter('val', $idUtilisateur)
                    ->getQuery()
                    ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
            for ($i = 0; $i< count($societes); $i++) {
                $societe = $em->getRepository(Societe::class)->findoneby(['id'=> $societes[$i]['id']]);
                for ($j = 0; $j< count($data['modules']); $j++) {
                    $module = $em->getRepository(Module::class)->findoneby(['id'=> $data['modules'][$j]['id']]);
                    $droit{$i} = new Droit();
                    $droit{$i}->setUtilisateurId($user);
                    $droit{$i}->setSocieteId($societe);
                    $droit{$i}->setModuleID($module);
                    $droit{$i}->setLectureEcritureSuppression($data['modules'][$j]['lectureEcritureSuppression']);
                    $droit{$i}->setSeulTous($data['modules'][$j]['SeulTous']);
                    $em->persist($droit{$i});
                    $em->flush();

                }
                // remettre les droits du gérant
                $this->droitGerant($societes[$i]['id']);
                // fin droit gérant
            }
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'le compte à bien été modifié.');
            return $this->redirectToRoute('list_utilisateur');
        }
        return $this->render('droit/editermass.html.twig', [
            'form' => $form->createView(), 
            'modules' => $modules,
            'mainNavRegistration' => true, 
            'title' => 'Droits de '.$user->getNomUtilisateur().' '.$user->getPrenomUtilisateur().' sur les sociétés attribuées',
        ]);
    }

     /**
     * @Route("/{tokenSocieteChercher}/editermassutilisateur", methods={"GET", "POST"}, name="editer_droit_societe_mass_utilisateur")
     */

    public function editermassutilisateur(Request $request, $tokenSocieteChercher): Response
    {
        $em = $this->getDoctrine()->getManager();
        $societe = $em->getRepository(Societe::class)->findOneBy(['tokenSociete'=>$tokenSocieteChercher]);
        $idSociete = $societe->getId();      
        $droits = array('droits' => $em->getRepository(Droit::class)->findBy([
            'SocieteId' => $idSociete,
        ]));
        $modules = array('modules' => $em->getRepository(Module::class)
                    ->createQueryBuilder('m')
                        ->select('m')
                        ->getQuery()
                        ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY));
        $form = $this->createForm(EditerDroitMassType::class, $modules);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $societe = $em->getRepository(Societe::class)->findOneBy(['tokenSociete'=>$tokenSocieteChercher]);
            $idSociete = $societe->getId();
            $droits = $em->getRepository(Droit::class)->findBy(['SocieteId'=>$idSociete]);
            foreach ($droits as $droitaEffacer) {
                $em->remove($droitaEffacer);
            }
            $em->flush();            
             $data = $form->getData();
             $utilisateurs = $em->getRepository(Utilisateur::class)
                    ->createQueryBuilder('u')
                    ->select('u.id')
                    ->join('u.societes', 's')
                    ->where('s.id = :val')
                    ->setParameter('val', $idSociete)
                    ->getQuery()
                    ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);        
            for ($i = 0; $i< count($utilisateurs); $i++) {
                $user = $em->getRepository(Utilisateur::class)->findoneby(['id'=> $utilisateurs[$i]['id']]);
                for ($j = 0; $j< count($data['modules']); $j++) {
                    $module = $em->getRepository(Module::class)->findoneby(['id'=> $data['modules'][$j]['id']]);

                    $droit{$i} = new Droit();
                    $droit{$i}->setUtilisateurId($user);
                    $droit{$i}->setSocieteId($societe);
                    $droit{$i}->setModuleID($module);
                    $droit{$i}->setLectureEcritureSuppression($data['modules'][$j]['lectureEcritureSuppression']);
                    $droit{$i}->setSeulTous($data['modules'][$j]['SeulTous']);
                    $em->persist($droit{$i});

                }
            }
            $em->flush();
            // remettre les droits du gérant
            $this->droitGerant($idSociete);
            // fin droit gérant
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'l\'opération à bien été effectué.');
            return $this->redirectToRoute('list_societe');
        }
        return $this->render('droit/editermass.html.twig', [
            'form' => $form->createView(), 
            'modules' => $modules,
            'mainNavSociete' => true, 
            'title' => 'Droits utilisateurs de '.$societe->getRaisonSocial(),
          //  'title' => $user->getNomUtilisateur().' '.$user->getPrenomUtilisateur(),
        ]);
    }


    public function droitGerant($idSociete) {
        $em = $this->getDoctrine()->getManager();
        // remettre les droits du gérant
        $societe = $em->getRepository(Societe::class)->findOneBy(['id'=>$idSociete]);
        $idUtilisateur = $societe->getIdUtilisateurGerant()->getId();
            $droitGerant = $em->getRepository(Droit::class)->findBy([
                'SocieteId' => $idSociete,
                'utilisateurId'=>$idUtilisateur,
            ]);
        foreach ($droitGerant as $droitGerantaEffacer) {
            $em->remove($droitGerantaEffacer);
        }
        $em->flush();
        $modules = $em->getRepository(Module::class)
                ->createQueryBuilder('m')
                ->select('m')
                ->getQuery()
                ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
        for ($i = 0; $i< count($modules); $i++) {
            $module = $em->getRepository(Module::class)->findoneby(['id'=> $modules[$i]['id']]);
            $droit{$i} = new Droit();
            $droit{$i}->setUtilisateurId($societe->getIdUtilisateurGerant());
            $droit{$i}->setSocieteId($societe);
            $droit{$i}->setModuleID($module);
            $droit{$i}->setLectureEcritureSuppression(3);
            $droit{$i}->setSeulTous(1);
            $em->persist($droit{$i});
        }
        $em->flush();
        // fin droit gérant
    }
}
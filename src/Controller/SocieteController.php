<?php

namespace App\Controller;


use App\Form\SocieteType;
use App\Form\EditSocieteType;
use App\Form\EditerUtilisateurSocieteType;
use App\Entity\Societe;
use App\Entity\Utilisateur;
use App\Events;
use App\Controller\DroitController;
use App\Entity\Droit;

use App\Entity\Module;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\GenericEvent;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

use Symfony\Component\HttpFoundation\Session\Session;

/** @Route("/societe") */
class SocieteController extends Controller {

    public $idModuleController = 1;
	/**
     * @Route("/", name="list_societe")
     */
    public function index()
    {
        $em = $this->getDoctrine()->getManager();
        $societes = $em->getRepository(Societe::class)->getSociete($this->getUser()->getId());

        $droit = new DroitController();
        $droit->setContainer($this->container);
        //    $nbDroit  = $droit->aDroit($this->getUser()->getId(), $societe->getId(), $this->$idModuleController);

        return $this->render('societe/index.html.twig', [
            'societes' => $societes,
            'title' => ' Gestion des dossiers',
            'mainNavSociete' => true,
            'menuExportAfficher' => true,
            'controllerIddroit' => $this->idModuleController,
            'idUtilisateurdroit' => $this->getUser()->getId(),
         //       'droitDB' => $nbDroit,
               /* 'droitLecture' => $nbDroit['lecture'],
                'droitModification' => $nbDroit['modification'],
                'droitAdmin' => $nbDroit['admin'],
                'droitBloque' => $nbDroit['bloque'],
                'droitTous' => $nbDroit['tous'],*/
        ]);
    }

    /**
     * @Route("/{tokenChercher}/ouvrir", methods={"GET", "POST"}, name="ouvrir_societe")
     */

    public function ouvrirSociete(Request $request, $tokenChercher): Response
    {
        $em = $this->getDoctrine()->getManager();

        if ($societe = $em->getRepository(Societe::class)->findOneBy(['tokenSociete'=>$tokenChercher])) 
        {
            $session = new Session();
            $session->set('tokenSocieteConnecte',$tokenChercher);

        }



        $em = $this->getDoctrine()->getManager();
        $societes = $em->getRepository(Societe::class)->getSociete($this->getUser()->getId());

        $droit = new DroitController();
        $droit->setContainer($this->container);
        //    $nbDroit  = $droit->aDroit($this->getUser()->getId(), $societe->getId(), $this->$idModuleController);

        return $this->render('societe/index.html.twig', [
            'societes' => $societes,
            'title' => ' Gestion des dossiers',
            'mainNavSociete' => true,
            'menuExportAfficher' => true,
            'controllerIddroit' => $this->idModuleController,
            'idUtilisateurdroit' => $this->getUser()->getId(),
            'societeAfficher'=> true // afficher le menu société et non pas la base
        //       'droitDB' => $nbDroit,
           /* 'droitLecture' => $nbDroit['lecture'],
            'droitModification' => $nbDroit['modification'],
            'droitAdmin' => $nbDroit['admin'],
            'droitBloque' => $nbDroit['bloque'],
            'droitTous' => $nbDroit['tous'],*/
        ]);
    }

    /**
     * @Route("/ajouter", name="ajouter_societe")
     */

    public function ajouterSocieteAction(Request $request, EventDispatcherInterface $eventDispatcher) {
        // 1) build the form
        $societe = new Societe();
		$entityManager = $this->getDoctrine()->getManager();
        $form = $this->createForm(SocieteType::class, $societe);
        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
        	
        	if (null !== $societe->getLogoSociete()) {
	            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */

	        	$file = $societe->getLogoSociete();

	            $fileName = $this->generateUniqueToken().'.'.$file-> getClientOriginalExtension();

	            // moves the file to the directory where brochures are stored
	            $file->move(
	                $this->getParameter('repertoire_logo_societe'),
	                $fileName
	            );

	            $societe->setLogoSociete($fileName);
        	}
            $tokenNouvelleSociete = $this->generateUniqueToken();
            $societe->setTokenSociete($tokenNouvelleSociete);
            $utilisateur = $entityManager->getRepository(Utilisateur::class)->findoneby(['id'=>$this->getUser()->getId()]);






            $modules = $entityManager->getRepository(Module::class)
                    ->createQueryBuilder('m')
                        ->select('m')
                        ->getQuery()
                        ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);


            for ($i = 0; $i< count($modules); $i++) {

                $module = $entityManager->getRepository(Module::class)->findoneby(['id'=> $modules[$i]['id']]);


                $droit{$modules[$i]['controllerModule']} = new Droit();
                $droit{$modules[$i]['controllerModule']}->setUtilisateurId($utilisateur);
                $droit{$modules[$i]['controllerModule']}->setSocieteId($societe);
                $droit{$modules[$i]['controllerModule']}->setModuleID($module);
                $droit{$modules[$i]['controllerModule']}->setLectureEcritureSuppression(3);
                $droit{$modules[$i]['controllerModule']}->setSeulTous(1);
                $entityManager->persist($droit{$modules[$i]['controllerModule']});
            }

            
         //   $utilisateur->addSociete($societe);
            $societe->setDateCreationSociete(new \DateTime());
            
            // 4) save the User!
           // $societe->getUtilisateurs()->add($utilisateur);
            

            $societe->setIdUtilisateurGerant($utilisateur);

            $societe->addUtilisateur($utilisateur);


            $entityManager->persist($societe);
           
            //$entityManager->persist($utilisateur);
            $entityManager->flush();


            //On déclenche l'event
            //  $event = new GenericEvent($user);
            // $eventDispatcher->dispatch(Events::USER_REGISTERED, $event);
            /// sSSS


            if ($this->getUser()->getIdParent() == Null) $idParentGerant = $this->getUser()->getId();
            else $idParentGerant = $this->getUser()->getIdParent();

            $nbUtilisateurs = $entityManager->getRepository(Utilisateur::class)->countUtilisateurFils($idParentGerant);

            /// ssSSS



            // ... do any other work - like sending them an email, etc
            // maybe set a "flash" success message for the user
            $this->addFlash('success', 'Votre société à bien été enregistrée.');
          //  return $this->redirectToRoute('list_societe');
            if ($nbUtilisateurs == 0) return $this->redirectToRoute('list_societe'); 
            else return $this->redirectToRoute('edition_societe_utilisateur', array('tokenChercher' => $tokenNouvelleSociete));
        }
        return $this->render('societe/formulaire.html.twig', ['form' => $form->createView(), 'mainNavSociete' => true, 'title' => 'Ajouter ma société']);
    }

    /**
     * @Route("/{tokenChercher}/editer", methods={"GET", "POST"}, name="editer_societe")
     */

    public function editer(Request $request, $tokenChercher): Response
    {
    	$em = $this->getDoctrine()->getManager();

    	if ($societe = $em->getRepository(Societe::class)->findOneBy(['tokenSociete'=>$tokenChercher])) 
        {

            $droit = new DroitController();
            $droit->setContainer($this->container);
            $nbDroit  = $droit->aDroit($this->getUser()->getId(), $societe->getId(), $this->idModuleController);


            if ($nbDroit >= 20) {
                $ancien_logo = $this->getAbsolutePathLogo($societe);
    	        $ancien_logo_url = $societe->getLogoSociete();
    	        $form = $this->createForm(EditSocieteType::class, $societe);
    	        $form->handleRequest($request);
    	        if ($form->isSubmitted() && $form->isValid()) {
    	        	if (null !== $societe->getLogoSociete()) {
    	        		 if (file_exists($ancien_logo) and $ancien_logo_url !== null)  unlink($ancien_logo);	    			
    		            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
    		        	$file = $societe->getLogoSociete();

    		            $fileName = $this->generateUniqueToken().'.'.$file-> getClientOriginalExtension();

    		            // moves the file to the directory where brochures are stored
    		            $file->move(
    		                $this->getParameter('repertoire_logo_societe'),
    		                $fileName
    		            );

    		            $societe->setLogoSociete($fileName);
    	        	} else $societe->setLogoSociete($ancien_logo_url);

    	            /*if(!empty($user->getMdpUtilisateur()) and $user->getMdpUtilisateur() !== null) {
    	                $password = $passwordEncoder->encodePassword($user, $user->getPassword());
    	                $user->setPassword($password);
    	            } else {
    	                $oldpassword = $user->getMdpUtilisateur();
    	                $user->setPassword($oldpassword);
    	            }*/

    	            $this->getDoctrine()->getManager()->flush();
    	            $this->addFlash('success', 'la société à bien été modifié.');
    	          //  return $this->redirectToRoute('admin_post_edit', ['id' => $post->getId()]);
    	        }
    	        return $this->render('societe/editer.html.twig', [
    	        	'form' => $form->createView(), 
    	        	'mainNavSociete' => true, 
    	        	'title' => $societe->getRaisonSocial(),
                    'controllerIddroit' => $this->idModuleController,
                    'idUtilisateurdroit' => $this->getUser()->getId(),
    	        ]);
            } else {

                $this->addFlash('danger', 'Vous n\'avez pas accès à cette page.');

                $societes = $em->getRepository(Societe::class)->getSociete($this->getUser()->getId());
                return $this->render('societe/index.html.twig', [
                'societes' => $societes,
                'controllerIddroit' => $this->idModuleController,
                'idUtilisateurdroit' => $this->getUser()->getId(),
                ]);

            }

        } else {

            $this->addFlash('danger', 'La société n\'existe pas.');

            $societes = $em->getRepository(Societe::class)->getSociete($this->getUser()->getId());
            return $this->render('societe/index.html.twig', [
            'societes' => $societes,
        	]);

     	}

    	
    }

    /**
     * @Route("/{tokenChercher}/info", methods={"GET", "POST"}, name="info_societe")
     */
    public function infoSociete(Request $request, $tokenChercher): Response
    {
        $em = $this->getDoctrine()->getManager();
        $societe = $em->getRepository(Societe::class)->findOneBy(['tokenSociete'=>$tokenChercher]);
        $utilisateurs = $em->getRepository(Utilisateur::class)->getUtilisateurSociete($societe->getId());

        
        return $this->render('societe/info.html.twig', [
            'utilisateurs' => $utilisateurs, 
            'societe' => $societe,
            ]);
    }

    /**
     * @Route("/{tokenChercher}/supprimer", methods={"GET", "POST"}, name="supprimer_societe")
     * @Security("has_role('ROLE_SUPPRESSION')")
     */

    public function supprimer(Request $request, $tokenChercher) 
    {
        $em = $this->getDoctrine()->getManager();


        $societe = $em->getRepository(Societe::class)->findOneBy(['tokenSociete'=>$tokenChercher]);


        $droit = new DroitController();
        $droit->setContainer($this->container);
        $nbDroit  = $droit->aDroit($this->getUser()->getId(), $societe->getId(), $this->idModuleController);


        if ($nbDroit >= 31) {

            $droits = $em->getRepository(Droit::class)->findBy(['SocieteId'=>$societe->getId()]);
            foreach ($droits as $droitaEffacer) {
                $em->remove($droitaEffacer);
            }
            $em->flush();

        //    $em = $this->getDoctrine()->getManager();
            $em->remove($societe);
            $em->flush();

            if (null !== $societe->getLogoSociete()) {
            	unlink($this->getAbsolutePathLogo($societe));
        	}





            $this->addFlash('success', 'le compte à bien été supprimé.');
            return $this->redirectToRoute('list_societe');

        /*
                    $em = $this->getDoctrine()->getManager();
                    $societes = $em->getRepository(Societe::class)->FindAll();
                    return $this->render('societe/index.html.twig', [
                        'societes' => $societes,
                        'mainNavSociete' => true,
                    ]);*/
        } else {

            $this->addFlash('danger', 'Vous n\'avez pas accès à cette fonctionnalité.');

            $societes = $em->getRepository(Societe::class)->getSociete($this->getUser()->getId());
            return $this->render('societe/index.html.twig', [
            'societes' => $societes,
            ]);

        }


    }
    /**
     * @Route("/{tokenChercher}/editionutilisateur", methods={"GET", "POST"}, name="edition_societe_utilisateur")
     */
    public function editionutilisateur(Request $request, $tokenChercher): Response
    {
        $em = $this->getDoctrine()->getManager();
        $societe = $em->getRepository(Societe::class)->findOneBy(['tokenSociete'=>$tokenChercher]);
        $idGerant = $societe->getIdUtilisateurGerant()->getId();

        $ancien_fichier_url = $societe->getLogoSociete();



        $form = $this->createForm(EditerUtilisateurSocieteType::class, $societe, [
            'idSociete' => $societe->getId(),
            'idGerant' => $idGerant,
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $nbUtilisateurs = $form['utilisateurs']->getData();
            $idUtilisateurChoisi = $nbUtilisateurs['0']->getid();


         //   echo  $idUtilisateurActuel. " - ".$idGerant;
          //  $user->setUrlPhoto($ancien_fichier_url);

            $societe->setLogoSociete($ancien_fichier_url);
            $societe->addUtilisateur($societe->getIdUtilisateurGerant());

            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'la société à bien été modifié.');
            if ((count($nbUtilisateurs) == 1) and ($idGerant ==  $idUtilisateurChoisi)) return $this->redirectToRoute('list_societe'); 
            else return $this->redirectToRoute('editer_droit_societe_mass_utilisateur', ['tokenSocieteChercher' => $tokenChercher]);
        }
        return $this->render('utilisateur/editer.html.twig', ['form' => $form->createView(), 'mainNavSociete' => true, 'title' => 'Utilisateurs de '.$societe->getRaisonSocial(),]);
    }


    public function getAbsolutePathLogoTwig($id)
    {

        $em = $this->getDoctrine()->getManager();
        if($societe = $em->getRepository(Societe::class)->findOneBy(['id'=>$id])) {
            if($societe->getLogoSociete() !== NULL) $photo = $this->getParameter('repertoire_logo_societe_web').'/'.$societe->getLogoSociete();
            else $photo = $this->getParameter('repertoire_logo_societe_web').'/inconnu.jpg';
        } else $photo = $this->getParameter('repertoire_logo_societe_web').'/inconnu.jpg';
        return $this->render('valeur.html.twig', [
            'valeur' => $photo,
        ]);
    }



    public function getAbsolutePathLogo(Societe $societe)
    {
        return  $this->getParameter('repertoire_logo_societe').'/'.$societe->getLogoSociete();
    }


    /**
     * @return string
     */
    private function generateUniqueToken()
    {
        // md5() reduces the similarity of the file names generated by
        // uniqid(), which is based on timestamps
        return md5(uniqid());
    }


    // Affichage Twig



    public function getinfoPrincipaleTwig($partie){
        $em = $this->getDoctrine()->getManager();
        $session = new Session();
        if($session->get('tokenSocieteConnecte') !== '') {
            if ($societe = $em->getRepository(Societe::class)->findOneBy(['tokenSociete'=>$session->get('tokenSocieteConnecte')])) 
            {
                if($societe->$partie()  !== null) $valeur = $societe->$partie();
                else $valeur = "vide";
            } else $valeur = "vide";

            


        } else {
            $userId = $this->getUser()->getId();
           
            if( $societe = $em->getRepository(Societe::class)->getSocietePrincipale($userId)) {
                if($societe->$partie()  !== null) $valeur = $societe->$partie();
                else $valeur = "vide";
            } else $valeur = "vide";
        }


        return $this->render('valeur.html.twig', [
            'valeur' => $valeur,
        ]);
    }





}
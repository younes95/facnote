<?php

namespace App\Controller;

use App\Form\UtilisateurType;
use App\Form\NouveauUtilisateurType;
use App\Form\EditerUtilisateurType;
use App\Form\EditerSocieteUtilisateurType;
use App\Form\EditerMdpUtilisateurType;
use App\Entity\Utilisateur;
use App\Entity\Societe;

use App\Controller\DroitController;
use App\Entity\Droit;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
/** @Route("/utilisateur") */

class UtilisateurController extends Controller
{
    public $idModuleController = 2;

    /**
     * @Route("/facnote", name="list_utilisateur_facnote")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function index()
    {
        $em = $this->getDoctrine()->getManager();
        $utilisateurs = $em->getRepository(Utilisateur::class)->FindAll();


        return $this->render('utilisateur/listtoutfacnote.html.twig', [
            'utilisateurs' => $utilisateurs,
            'mainNavUtilisateur' => true,
            'menuExportAfficher' => true,
            'title' => 'Liste des utilisateurs'
         //   'photoUtilisateur' => $this->getAbsolutePathFichierTwig(),
        ]);
    }

    /**
     * @Route("/", name="list_utilisateur")
     */
    public function listUtilisateur()
    {
        $em = $this->getDoctrine()->getManager();
        if ($this->getUser()->getIdParent() == Null) $idParentGerant = $this->getUser()->getId();
            else $idParentGerant = $this->getUser()->getIdParent();



        $utilisateurs = $em->getRepository(Utilisateur::class)->Findby([
            'idParent' => $idParentGerant,

        ]);


        $societe = $em->getRepository(Societe::class)->getSocietePrincipale($this->getUser()->getId());


        return $this->render('utilisateur/listtout.html.twig', [
            'utilisateurs' => $utilisateurs,
            'mainNavUtilisateur' => true,
            'menuExportAfficher' => true,
            'title' => 'Liste des utilisateurs '. $societe->getRaisonSocial(),
         //   'photoUtilisateur' => $this->getAbsolutePathFichierTwig(),
        ]);
    }


    /**
     * @Route("/{tokenUtilisateurChercher}/editer", methods={"GET", "POST"}, name="editer_utilisateur")
     * @Security("has_role('ROLE_EDITION')")
     */

    public function editer(Request $request, $tokenUtilisateurChercher): Response
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(Utilisateur::class)->findOneBy(['tokenUtilisateur'=>$tokenUtilisateurChercher]);


        $ancien_fichier = $this->getAbsolutePathFichier($user);
        $ancien_fichier_url = $user->getUrlPhoto();

        $form = $this->createForm(EditerUtilisateurType::class, $user, ['idConnecter' => $this->getUser()->getId(),]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            if (null !== $user->getUrlPhoto()) {
                if (file_exists($ancien_fichier) and $ancien_fichier_url !== null) unlink($ancien_fichier);
                

                /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */

                $file = $user->getUrlPhoto();

                $fileName = $this->genererToken().'.'.$file-> getClientOriginalExtension();

                // moves the file to the directory where brochures are stored
                $file->move(
                    $this->getParameter('repertoire_photo_utilisateur'),
                    $fileName
                );

                $user->setUrlPhoto($fileName);
            } else $user->setUrlPhoto($ancien_fichier_url);


            

            /*if(!empty($user->getMdpUtilisateur()) and $user->getMdpUtilisateur() !== null) {
                $password = $passwordEncoder->encodePassword($user, $user->getPassword());
                $user->setPassword($password);
            } else {
                $oldpassword = $user->getMdpUtilisateur();
                $user->setPassword($oldpassword);
            }*/

            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'l\'utilisateur à bien été modifié.');


            // return $this->redirectToRoute('list_utilisateur', ['id' => $post->getId()]);
            if($user->getId() !== $this->getUser()->getId())  return $this->redirectToRoute('edition_utilisateur_societe', array('tokenUtilisateurChercher' => $tokenUtilisateurChercher));
        }
        return $this->render('utilisateur/editer.html.twig', [
            'form' => $form->createView(), 
            'mainNavRegistration' => true, 
            'title' => $user->getNomUtilisateur().' '.$user->getPrenomUtilisateur(),
        ]);
    }

    /**
     * @Route("/{tokenUtilisateurChercher}/info", methods={"GET", "POST"}, name="info_utilisateur")
     */
    public function infoUtilisateur(Request $request, $tokenUtilisateurChercher): Response
    {
        $em = $this->getDoctrine()->getManager();
        $utilisateur = $em->getRepository(Utilisateur::class)->findOneBy(['tokenUtilisateur'=>$tokenUtilisateurChercher]);
        $societes = $em->getRepository(Societe::class)->getSociete($utilisateur->getId());

        
        return $this->render('utilisateur/info.html.twig', [
            'utilisateur' => $utilisateur, 
            'societes' => $societes,
            ]);
    }


    public function societeUtilisateur() {

        $em = $this->getDoctrine()->getManager();
        return $societes = $em->getRepository(Societe::class)->getSociete($this->getUser()->getId());
    }

    /**
     * @Route("/{tokenChercher}/societe", methods={"GET", "POST"}, name="list_utilisateur_societe")
     */
    public function societe(Request $request, $tokenChercher): Response
    {
        $em = $this->getDoctrine()->getManager();

        if ($societebyToken = $em->getRepository(Societe::class)->findOneBy(['tokenSociete'=>$tokenChercher])) 
        {

            $utilisateurs = $em->getRepository(Utilisateur::class)->getUtilisateurSociete($societebyToken->getId());

        } else {

            $this->addFlash('danger', 'La société n\'existe pas.');

            $societes = $em->getRepository(Societe::class)->getSociete($this->getUser()->getId());
            return $this->render('societe/index.html.twig', [
            'societes' => $societes,
            'menuExportAfficher' => true,
            
        ]);

        }
      //  $utilisateurs = $em->getRepository(Utilisateur::class)->FindAll();


        return $this->render('utilisateur/index.html.twig', [
            'utilisateurs' => $utilisateurs,
            'societe' => $societebyToken,
            'societetoken' => $tokenChercher,
            'title' => 'Utilisateurs de '.$societebyToken->getRaisonSocial(),
            'menuExportAfficher' => true,
        ]);
    }

    /**
     * @Route("/ajouter", methods={"GET", "POST"}, name="ajouter_utilisateur")
     * @Security("has_role('ROLE_EDITION')")
     */
    public function ajouterAction(Request $request, UserPasswordEncoderInterface $passwordEncoder) {
        // 1) build the form
        $user = new Utilisateur();
        $societes = $this->societeUtilisateur();
        $form = $this->createForm(NouveauUtilisateurType::class, $user, ['idConnecter' => $this->getUser()->getId(),]);
        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $tokenNouveauUtilisateur = $this->genererToken();
            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            if (null !== $user->getUrlPhoto()) {
                $file = $user->getUrlPhoto();

                $fileName = $this->genererToken().'.'.$file-> getClientOriginalExtension();

                // moves the file to the directory where brochures are stored
                $file->move(
                    $this->getParameter('repertoire_photo_utilisateur'),
                    $fileName
                );

                // updates the 'brochure' property to store the PDF file name
                // instead of its contents
                $user->setUrlPhoto($fileName);
            }
            // 3) Encode the password (you could also do this via Doctrine listener)
            $password = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);
            $user->setTokenUtilisateur($tokenNouveauUtilisateur);

            if ($this->getUser()->getIdParent() == Null) $idParentGerant = $this->getUser()->getId();
            else $idParentGerant = $this->getUser()->getIdParent();

            $user->setIdParent($idParentGerant);
            //on active par défaut
          //  $user->addRole($user->getRoles());

            $user->setIsActiveUtilisateur(true);
            $user->setDateInscriptionUtilisateur(new \DateTime());

           // $user->addSociete($societes);
         // $user->setDateInscriptionUtilisateur(new \DateTime());
            
            // 4) save the User!
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();


            //On déclenche l'event
          //  $event = new GenericEvent($user);
           // $eventDispatcher->dispatch(Events::USER_REGISTERED, $event);


            // ... do any other work - like sending them an email, etc
            // maybe set a "flash" success message for the user
            $this->addFlash('success', 'l\'utilisateur à bien été enregistré.');
            return $this->redirectToRoute('edition_utilisateur_societe', array('tokenUtilisateurChercher' => $tokenNouveauUtilisateur));
        }
        return $this->render('utilisateur/ajouter.html.twig', ['form' => $form->createView(), 'mainNavUtilisateur' => true, 'title' => 'Ajouter utilisateur']);
    }


    /**
     * @Route("/{tokenUtilisateurChercher}/editionsociete", methods={"GET", "POST"}, name="edition_utilisateur_societe")
     */
    public function editionsociete(Request $request, $tokenUtilisateurChercher): Response
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(Utilisateur::class)->findOneBy(['tokenUtilisateur'=>$tokenUtilisateurChercher]);

        $ancien_fichier_url = $user->getUrlPhoto();


        $form = $this->createForm(EditerSocieteUtilisateurType::class, $user, ['idConnecter' => $this->getUser()->getId(),]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

           
            $user->setUrlPhoto($ancien_fichier_url);

            // Affecter l'utilisateur à la société principale
            $societeprincipale = $em->getRepository(Societe::class)->getSocietePrincipale($user->getIdParent());  
            if ($societeprincipale->getIdTypeSociete()->getId() == 1) // cabinnet expert comptable
            {
                $user->addSociete($societeprincipale);
            } 
            

            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'le compte à bien été modifié.');
            return $this->redirectToRoute('editer_droit_utilisateur_mass_societe', ['tokenUtilisateurChercher' => $tokenUtilisateurChercher]);
        }
        return $this->render('utilisateur/editersociete.html.twig', [
            'form' => $form->createView(), 
            'mainNavUtilisateur' => true, 
            'title' => 'Société affectés à '.$user->getNomUtilisateur().' '.$user->getPrenomUtilisateur(),
        ]);
    }



    /**
     * @Route("/{tokenUtilisateurChercher}/editermdp", methods={"GET", "POST"}, name="editer_utilisateur_mdp")
     */

    public function editerMdp(Request $request, $tokenUtilisateurChercher, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(Utilisateur::class)->findOneBy(['tokenUtilisateur'=>$tokenUtilisateurChercher]);
        $form = $this->createForm(EditerMdpUtilisateurType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $password = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);
            

            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'le compte à bien été modifié.');
          //  return $this->redirectToRoute('admin_post_edit', ['id' => $post->getId()]);
        }
        return $this->render('utilisateur/editer.html.twig', ['form' => $form->createView(), 'mainNavUtilisateur' => true, 'title' => 'Edition']);
    }

    /**
     * @Route("/{tokenUtilisateurChercher}/supprimer", methods={"GET", "POST"}, name="supprimer_utilisateur")
     */

    public function supprimer(Request $request, $tokenUtilisateurChercher) 
    {

        $em = $this->getDoctrine()->getManager();

        $utilisateur = $em->getRepository(Utilisateur::class)->findOneBy(['tokenUtilisateur'=>$tokenUtilisateurChercher]);

        $idUtilisateurConnecter = $this->getUser()->getId();


        $societe = $em->getRepository(Societe::class)->getSocietePrincipale($idUtilisateurConnecter);

        if($idUtilisateurConnecter !== $utilisateur->getId() ) {

            $droit = new DroitController();
            $droit->setContainer($this->container);
            $nbDroit  = $droit->aDroit($idUtilisateurConnecter, $societe->getId(), $this->idModuleController);
            if ($nbDroit >= 31) {

                $droits = $em->getRepository(Droit::class)->findBy(['utilisateurId'=>$utilisateur->getId()]);
                foreach ($droits as $droitaEffacer) {
                    $em->remove($droitaEffacer);
                }
                $em->flush();

            //    $em = $this->getDoctrine()->getManager();
                
                $em->remove($utilisateur);
                $em->flush();

                if (file_exists($this->getAbsolutePathFichier($utilisateur)) and $utilisateur->getUrlPhoto() !== null ) unlink($this->getAbsolutePathFichier($utilisateur));
                $this->addFlash('success', 'le compte à bien été supprimé.');
                $this->addFlash('success', 'le compte à bien été supprimé.');
                return $this->redirectToRoute('list_utilisateur');
            } else {

                $this->addFlash('danger', 'Vous n\'avez pas accès à cette fonctionnalité.');

                if ($this->getUser()->getIdParent() == Null) $idParentGerant = $this->getUser()->getId();
                else $idParentGerant = $this->getUser()->getIdParent();



                $utilisateurs = $em->getRepository(Utilisateur::class)->Findby([
                    'idParent' => $idParentGerant,

                ]);

             //   $utilisateurs = $em->getRepository(Utilisateur::class)->FindAll();
                return $this->render('utilisateur/index.html.twig', [
                    'utilisateurs' => $utilisateurs,
                    'mainNavUtilisateur' => true,
                ]);

            }
         } else {

            $this->addFlash('danger', 'Vous ne pouvez pas supprimer votre compte.');

            if ($this->getUser()->getIdParent() == Null) $idParentGerant = $this->getUser()->getId();
                else $idParentGerant = $this->getUser()->getIdParent();



                $utilisateurs = $em->getRepository(Utilisateur::class)->Findby([
                    'idParent' => $idParentGerant,

                ]);

           // $utilisateurs = $em->getRepository(Utilisateur::class)->FindAll();
            return $this->render('utilisateur/index.html.twig', [
                'utilisateurs' => $utilisateurs,
                'mainNavUtilisateur' => true,
            ]);

        }
    }


    /**
     * @Route("/{tokenUtilisateurChercher}/{tokenSocieteChercher}/supprimerusersociete", methods={"GET", "POST"}, name="supprimer_utilisateur_societe")
     */

    public function supprimerUtilisateurSociete(Request $request, $tokenUtilisateurChercher, $tokenSocieteChercher) 
    {

        $em = $this->getDoctrine()->getManager();

        $utilisateur = $em->getRepository(Utilisateur::class)->findOneBy(['tokenUtilisateur'=>$tokenUtilisateurChercher]);
        $societe = $em->getRepository(Societe::class)->findOneBy(['tokenSociete'=>$tokenSocieteChercher]);

        $idUtilisateurConnecter = $this->getUser()->getId();

        if($idUtilisateurConnecter !== $utilisateur->getId() ) {


            $droit = new DroitController();
            $droit->setContainer($this->container);
            $nbDroit  = $droit->aDroit($idUtilisateurConnecter, $societe->getId(), $this->idModuleController);
            if ($nbDroit >= 31) {

                $droits = $em->getRepository(Droit::class)->findBy(['utilisateurId'=>$utilisateur->getId()]);
                foreach ($droits as $droitaEffacer) {
                    $em->remove($droitaEffacer);
                }
                $em->flush();

            //    $em = $this->getDoctrine()->getManager();
                
                $em->remove($utilisateur);
                $em->flush();

                if (file_exists($this->getAbsolutePathFichier($utilisateur)) and $utilisateur->getUrlPhoto() !== null ) unlink($this->getAbsolutePathFichier($utilisateur));



                $this->addFlash('success', 'le compte à bien été supprimé.');




                $this->addFlash('success', 'le compte à bien été supprimé.');
                return $this->redirectToRoute('list_utilisateur');

        /*
                $em = $this->getDoctrine()->getManager();
                $societes = $em->getRepository(Societe::class)->FindAll();
                return $this->render('societe/index.html.twig', [
                    'societes' => $societes,
                    'mainNavSociete' => true,
                ]);*/
            } else {

                $this->addFlash('danger', 'Vous n\'avez pas accès à cette fonctionnalité.');



                if ($this->getUser()->getIdParent() == Null) $idParentGerant = $this->getUser()->getId();
                else $idParentGerant = $this->getUser()->getIdParent();



                $utilisateurs = $em->getRepository(Utilisateur::class)->Findby([
                    'idParent' => $idParentGerant,

                ]);



             //   $utilisateurs = $em->getRepository(Utilisateur::class)->FindAll();
                return $this->render('utilisateur/index.html.twig', [
                    'utilisateurs' => $utilisateurs,
                    'societetoken' => $societe->getTokenSociete(),
                    'mainNavUtilisateur' => true,
                ]);

            }
        } else {

            $this->addFlash('danger', 'Vous ne pouvez pas supprimer votre compte.');

            if ($this->getUser()->getIdParent() == Null) $idParentGerant = $this->getUser()->getId();
                else $idParentGerant = $this->getUser()->getIdParent();



                $utilisateurs = $em->getRepository(Utilisateur::class)->Findby([
                    'idParent' => $idParentGerant,

                ]);

          //  $utilisateurs = $em->getRepository(Utilisateur::class)->FindAll();
            return $this->render('utilisateur/index.html.twig', [
                'utilisateurs' => $utilisateurs,
                'societetoken' => $societe->getTokenSociete(),
                'mainNavUtilisateur' => true,
            ]);

        }
    }

    /**
     * @return string
     */
    private function genererToken()
    {
        // md5() reduces the similarity of the file names generated by
        // uniqid(), which is based on timestamps
        return md5(uniqid());
    }

    public function getAbsolutePathFichier(Utilisateur $utilisateur)
    {
        return  $this->getParameter('repertoire_photo_utilisateur').'/'.$utilisateur->getUrlPhoto();
    }

    public function getAbsolutePathFichierTwig()
    {
        $userId = $this->getUser()->getId();

        $em = $this->getDoctrine()->getManager();
        $utilisateur = $em->getRepository(Utilisateur::class)->findOneBy(['id'=>$userId]);
        if($utilisateur->getUrlPhoto() !== NULL) $photo = $this->getParameter('repertoire_photo_utilisateur_web').'/'.$utilisateur->getUrlPhoto();
        else $photo = $this->getParameter('repertoire_photo_utilisateur_web').'/inconnu.jpg';
        return $this->render('valeur.html.twig', [
            'valeur' => $photo,
        ]);
    }
   
}

<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use App\Entity\Client;
use App\Entity\Societe;

use App\Controller\DroitController;
use App\Entity\Droit;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\HttpFoundation\Session\Session;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


use App\Form\NouveauClientType;

/** @Route("/client") */

class ClientController extends Controller
{
	public $idModuleController = 6;

    /**
     * @Route("/", name="list_client")
     */
    public function index(Request $request)
    {
    	
    	$session = new Session();
    	$tokenSociete = $session->get('tokenSocieteConnecte');
    	$em = $this->getDoctrine()->getManager();

    	$societe = $em->getRepository(Societe::class)->findOneBy(['tokenSociete'=>$tokenSociete]);
        

        $clients = $em->getRepository(Client::class)->Findby([
            'idSociete' => $societe->getId(),

        ]);

        $form = $this->ajouter($request);

        return $this->render('client/list.html.twig', [
            'clients' => $clients,
            'mainNavClient' => true,
            'menuExportAfficher' => true,
            'title' => 'Liste des clients '. $societe->getRaisonSocial(),
            'form' => $form->createView(),
         //   'photoUtilisateur' => $this->getAbsolutePathFichierTwig(),
        ]);
    }

    /**
     * @Route("/ajouter", methods={"GET", "POST"}, name="ajouter_client")
     */
    public function ajouter(Request $request) {

    	$session = new Session();
    	$tokenSociete = $session->get('tokenSocieteConnecte');
    	$em = $this->getDoctrine()->getManager();



    	$societe = $em->getRepository(Societe::class)->findOneBy(['tokenSociete'=>$tokenSociete]);


        // 1) build the form
        $client = new Client();
        $form = $this->createForm(NouveauClientType::class, $client, ['idSociete' => $societe->getId(),]);
        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $tokenNouveauClient = $this->genererToken();
            
            
            $client->setTokenClient($tokenNouveauClient);
            $client->setIdSociete($societe);

           
            //on active par défaut

            $client->setIsActiveClient(true);
            
            // 4) save the User!
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($client);
            $entityManager->flush();


            //On déclenche l'event
          //  $event = new GenericEvent($user);
           // $eventDispatcher->dispatch(Events::USER_REGISTERED, $event);


            // ... do any other work - like sending them an email, etc
            // maybe set a "flash" success message for the user
            $this->addFlash('success', 'le client à bien été enregistré.');
            $clients = $em->getRepository(Client::class)->Findby([
            'idSociete' => $societe->getId(),

        	]);

            return $this->render('client/list.html.twig', [
	            'clients' => $clients,
	            'mainNavClient' => true,
	            'menuExportAfficher' => true,
	            'title' => 'Liste des clients '. $societe->getRaisonSocial(),
        	]);
        }
     //   return $this->render('client/ajouter.html.twig', ['form' => $form->createView(), 'mainNavClient' => true, 'title' => 'Ajouter client']);
        return $form;
    }


    /**
     * @Route("/{tokenClientChercher}/editer", methods={"GET", "POST"}, name="editer_client")
     */

    public function editer(Request $request, $tokenClientChercher): Response
    {
        $em = $this->getDoctrine()->getManager();
        $client = $em->getRepository(Client::class)->findOneBy(['tokenClient'=>$tokenClientChercher]);


  

        $form = $this->createForm(EditerClientType::class, $user, ['idConnecter' => $this->getUser()->getId(),]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {



            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'le client à bien été modifié.');


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
     * @return string
     */
    private function genererToken()
    {
        // md5() reduces the similarity of the file names generated by
        // uniqid(), which is based on timestamps
        return md5(uniqid());
    }
}

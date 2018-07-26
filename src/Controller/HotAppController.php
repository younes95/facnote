<?php

namespace App\Controller;

use App\Entity\Ecriture;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Societe;

class HotAppController extends Controller
{
    public $societe = 1;//to take from a defined place

    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        $em = $this->getDoctrine()->getManager();
        $rawEcritures = $em->getRepository('App:Ecriture')->findBy(
            array(),
            array('tokenEcriture' => 'ASC', 'id' => 'ASC')
        );
        $numerosCompte = $em->getRepository('App:Ecriture')->findAllNumeroCompte();
        $exercices = $em->getRepository('App:Exercice')->findAllForSelect();
        $journaux = $em->getRepository('App:Journal')->findAllForSelect();
        $ecritures = [];
        foreach ($rawEcritures as $ecriture) {
            $e = [
                'id' => $ecriture->getId(),
                'tokenEcriture' => $ecriture->getTokenEcriture(),
                'idExercice' => $ecriture->getIdExercice() !== null ? $ecriture->getIdExercice()->getLibelle() : "",
                'idJournal' => $ecriture->getIdJournal() !== null ? $ecriture->getIdJournal()->getLibelle() : "",
                'libelle' => $ecriture->getLibelle(),
                'numeroCompte' => $ecriture->getNumeroCompte(),
                'date' => $ecriture->getDate() !== null ? $ecriture->getDate()->format('d-m-Y') : "",
                'credit' => $ecriture->getCredit(),
                'debit' => $ecriture->getDebit(),
                'img' => $ecriture->getImgName(),
            ];
            $ecritures[] = $e;
        }
        return $this->render('hot_app/index.html.twig', [
            'controller_name' => 'HotAppController',
            'ecritures' => json_encode($ecritures),
            'journaux' => json_encode($journaux),
            'exercices' => json_encode($exercices),
            'numerosCompte' => json_encode($numerosCompte),
        ]);
    }

    /**
     *
     * @Route("cell/save", name="save_cell")
     */
    public function updateCell(Request $req)
    {
        $id = $req->request->getInt('id');
        $em = $this->getDoctrine()->getManager();
        $ecriture = $em->getRepository('App:Ecriture')->find($req->request->getInt('id'));
        $token = null;
        $setterName = "set" . ucwords($req->get("changes")[0][1]);//get name of column from the list and concat with set then camelcase
        $column = $req->get("changes")[0][1];
        $newValue = $req->get("changes")[0][3];
        $token = null;
        //Si ecriture exist sur la base, alors update, sinon créer nvelle avec les valeurs par defaut
        if ($ecriture !== NULL) {
            switch ($column) {
                case "idExercice":
                    $newValue = $em->getReference('App:Exercice', $newValue);
                    break;
                case "idJournal":
                    $newValue = $em->getReference('App:Journal', $newValue);
                    break;
                case "date":
                    $newValue = new \DateTime($newValue);
                    break;
            }

            $ecriture->$setterName($newValue);
            $em->persist($ecriture);
            $em->flush();
            $token = $ecriture->getTokenEcriture();

        } else {
            $ecriture = new Ecriture();
            $ecriture->setTokenEcriture(uniqid());
            $ecriture->setIdSociete($em->getReference('App:Societe', $this->societe));
            $ecriture->setIdJournal($em->getReference('App:Journal', 1));//findByLabel empty
            $ecriture->setIdExercice($em->getReference('App:Exercice', 1));
            switch ($column) {
                case "idExercice":
                    $newValue = $em->getReference('App:Exercice', $newValue);
                    break;
                case "idJournal":
                    $newValue = $em->getReference('App:Journal', $newValue);
                    break;
                case "date":
                    $newValue = new \DateTime($newValue);
                    break;
            }
            $ecriture->$setterName($newValue);
            $em->persist($ecriture);
            $em->flush();

            $id = $ecriture->getId();
            $token = $ecriture->getTokenEcriture();
        }
        return new JsonResponse(array("result" => "ok", "val" => $newValue, "id" => $id, "token" => $token));

    }

    /**
     *
     * @Route("row/new", name="new_row")
     */
    public function newRow(Request $req)
    {
        $id = $req->request->get('index');
        $em = $this->getDoctrine()->getManager();
        $e = $this->getDoctrine()->getManager()->getRepository('App:Ecriture')->find($id);
        $ecriture2 = new Ecriture();
        $ecriture2->setIdSociete($em->getReference('App:Societe', $this->societe));
        $ecriture2->setIdExercice($e->getIdExercice());
        $ecriture2->setIdJournal($e->getIdJournal());
        $ecriture2->setTokenEcriture($e->getTokenEcriture());
        $em->persist($ecriture2);
        $em->flush();
        return new JsonResponse(array("result" => "ok", "id" => $ecriture2->getId()));
    }

    /**
     *
     * @Route("row/remove", name="remove_row")
     */
    public function removeRow(Request $req)
    {
        $id = $req->request->get('index');
        $e = $this->getDoctrine()->getManager()->getRepository('App:Ecriture')->find($id);

        $this->getDoctrine()->getManager()->remove($e);
        $this->getDoctrine()->getManager()->flush();
        return new JsonResponse(array("result" => "ok"));
    }
}
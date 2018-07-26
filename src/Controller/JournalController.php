<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class JournalController extends Controller
{
    /**
     * @Route("/journal", name="journal")
     */
    public function index()
    {
        return $this->render('journal/index.html.twig', [
            'controller_name' => 'JournalController',
        ]);
    }
}

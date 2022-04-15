<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EntrepriseController extends AbstractController
{
    /**
     * 
     * @Route("/recruteur", name="app_recruteur")
     * IsGranted("ROLE_RECRUTEUR")
     * @return Response
     */

    public function index(): Response
    {
        return $this->render('entreprise/entreprise.html.twig', ['page' => 'admin']);
    }
}

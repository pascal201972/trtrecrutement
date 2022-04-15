<?php

namespace App\Controller;

use App\Services\Bdd;
use App\Entity\TrtUser;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ConsultantController extends AbstractController
{

    /**
     * 
     * @Route("/consultant", name="app_consultant")
     * IsGranted("ROLE_USER")
     * @return Response
     */
    public function index(Bdd $basedd): Response
    {

        $listeCandidats = $basedd->getProfilUserRole('ROLE_CANDIDAT');
        $listeRecruteurs = $basedd->getProfilUserRole('ROLE_RECRUTEUR');

        return $this->render(
            'consultant/consultant.html.twig',
            [
                'page' => 'admin',
                'candidats' => $listeCandidats,
                'recruteurs' => $listeRecruteurs

            ]
        );
    }
}

<?php

namespace App\Controller;

use App\Services\Bdd;
use App\Entity\TrtUser;
use App\Form\MdpFormType;
use App\Form\ResetPassEmailType;

use App\Controller\BddController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\TrtProfilcandidatRepository;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\TrtProfilrecruteurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ConsultantController extends BddController
{

    /**
     * 
     * @Route("/consultant", name="app_consultant")
     *
     * IsGranted("ROLE_CONSULTANT")
     * @return Response
     */
    public function index(Request $request): Response
    {
        $route = "app_consultant";
        $user = $this->getUser();
        $formemail = $this->createForm(ResetPassEmailType::class);
        $formMdp = $this->createForm(MdpFormType::class);
        $this->formprofil($route, $user, $request, $formemail, $formMdp);
        return $this->render(
            'consultant/consultant.html.twig',
            [
                'onglet' => 'profil',
                'formemail' => $formemail->createView(),
                'formMdp' => $formMdp->createView()
            ]
        );
    }
    /**
     * 
     * @Route("/consultant/liste/candidat", name="app_consultant_candidat")
     * @Route("/consultant/voir/candidat/{id}", name="app_consultant_voircandidat")
     * IsGranted("ROLE_CONSULTANT")
     * @return Response
     */
    public function candidat($id = null): Response
    {
        $parametres = $this->getListe($id, 'ROLE_CANDIDAT', 'candidat');
        return $this->render(
            'consultant/consultant.html.twig',
            $parametres

        );
    }
    /**
     *
     * @Route("/consultant/liste/recruteur", name="app_consultant_recruteur")
     * @Route("/consultant/voir/recruteur/{id}", name="app_consultant_voirrecruteur")
     * IsGranted("ROLE_CONSULTANT")
     * @return Response
     */
    public function recruteur($id = null): Response
    {
        $parametres = $this->getListe($id, 'ROLE_RECRUTEUR', 'recruteur');
        return $this->render(
            'consultant/consultant.html.twig',
            $parametres

        );
    }
    /**
     * 
     * @Route("/consultant/validation/{id}", name="app_consultant_validation")
     * IsGranted("ROLE_CONSULTANT")
     * @return Response
     */
    public function Validation($id)
    {

        $user = $this->reposUser->findOneBy(['id' => $id]);
        $profil = $this->btn_validation($user, 1);

        return $this->redirectToRoute('app_consultant_' . $profil, ['onglet' => $profil]);
    }

    /**
     * 
     * @Route("/consultant/desactivation/{id}", name="app_consultant_desactivation")
     * IsGranted("ROLE_CONSULTANT")
     * @return Response
     */
    public function deactivation($id)
    {
        $user = $this->reposUser->findOneBy(['id' => $id]);
        $profil = $this->btn_validation($user, 0);

        return $this->redirectToRoute('app_consultant_' . $profil, ['onglet' => $profil]);
    }

    private  function getListe($id = null, $profilrole, $onglet)
    {
        $userprofil = null;
        $fiche = false;
        $profil = "";
        if ($id != null) {
            $userprofil = $this->reposUser->findOneBy(["id" => $id]);
            $roles = $userprofil->getRoles();
            $role = $roles[0];
            $profiles = explode('_', $role);
            $profil = strtolower($profiles[1]);
            $fiche = true;
        }
        $listes = $this->getUserRole($profilrole);
        return $parametres = [
            'page' => 'administration',
            'onglet' => $onglet,
            'listes' => $listes,
            'userprofil' => $userprofil,
            'profil' => $profil,
            'fiche' => $fiche

        ];
    }
    private function btn_validation($user, $etat)
    {
        $user->setValider($etat);
        $roles = $user->getRoles();
        $role = $roles[0];
        $profiles = explode('_', $role);
        $profil = strtolower($profiles[1]);
        $this->entityManager->persist($user);
        $this->entityManager->flush();
        return $profil;
    }


    /**
     *
     * @Route("/consultant/liste/annonce", name="app_consultant_annonce")
     * 
     * IsGranted("ROLE_CONSULTANT")
     * @return Response
     */
    public function listeAnnonce(): Response
    {
        //  $parametres = $this->getListe($basedd, $id, 'ROLE_RECRUTEUR', 'recruteur');
        $listeAnnonces = $this->reposAnnonce->findAll();




        return $this->render(
            'consultant/consultant.html.twig',
            [
                'onglet' => 'annonce',
                'fiche' => false,
                'listeannonces' => $listeAnnonces,

            ]
        );
    }
    /**
     *
     * @Route("/consultant/voir/annonce/{id}", name="app_consultant_annonce_voir")
     * 
     * IsGranted("ROLE_CONSULTANT")
     * @return Response
     */
    public function VoirAnnonce($id = null): Response
    {
        $listeAnnonces = $this->reposAnnonce->findAll();

        return $this->render(
            'consultant/consultant.html.twig',
            [
                'onglet' => 'annonce',
                'fiche' => false,
                'listeannonces' => $listeAnnonces
            ]
        );
    }

    /**
     *
     * @Route("/consultant/liste/annonce/valider/{id}", name="app_consultant_annonce_validation")
     * 
     * IsGranted("ROLE_CONSULTANT")
     * @return Response
     */

    public function ValiderAnnonce($id)
    {
        $listeAnnonces = $this->reposAnnonce->findAll();
        $annonce = $this->reposAnnonce->findOneBy(['id' => $id]);
        if ($annonce->getComplet()) {
            $annonce->setValider(true);
            $this->entityManager->persist($annonce);
            $this->entityManager->flush();
            return $this->redirectToRoute('app_consultant_annonce', [
                'onglet' => 'annonce',
                'fiche' => false,
                'listeannonces' => $listeAnnonces
            ]);
        }
    }
    /**
     *
     * @Route("/consultant/liste/annonce/desactiver/{id}", name="app_consultant_annonce_desactivation")
     * IsGranted("ROLE_CONSULTANT")
     * @return Response
     */
    public function deactiverAnnonce($id)
    {
        $listeAnnonces = $this->reposAnnonce->findAll();
        $annonce = $this->reposAnnonce->findOneBy(['id' => $id]);

        $annonce->setValider(false);
        $this->entityManager->persist($annonce);
        $this->entityManager->flush();
        return $this->redirectToRoute('app_consultant_annonce', [
            'onglet' => 'annonce',
            'fiche' => false,
            'listeannonces' => $listeAnnonces
        ]);
    }


    /**
     *
     * @Route("/consultant/liste/candidatures", name="app_consultant_candidatures")
     * 
     * IsGranted("ROLE_CONSULTANT")
     * @return Response
     */
    public function listecandidatures(): Response
    {
        //  $parametres = $this->getListe($basedd, $id, 'ROLE_RECRUTEUR', 'recruteur');
        $listecandidature = $this->reposAnnonce->findAll();
        return $this->render(
            'consultant/consultant.html.twig',
            [
                'onglet' => 'candidatures',
                'fiche' => false,
                'liste' => $listecandidature
            ]
        );
    }
}

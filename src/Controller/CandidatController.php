<?php

namespace App\Controller;

use App\Services\Bdd;
use App\Form\FormCvType;
use Spatie\PdfToImage\Pdf;
use App\Controller\BddController;
use App\Entity\TrtProfilcandidat;
use App\Form\FormProfilCandidatType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\TrtProfilcandidatRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class CandidatController extends BddController
{
    /** 
     * @Route("/candidat/", name= "app_candidat")
     * IsGranted('ROLE_CANDIDAT')
     */
    public function index(SluggerInterface $slugger, Request $request): Response
    {
        $user = $this->getUser();
        if ($user->getTrtProfilcandidat())
            $profil = $this->reposProfilCdt->findOneByUser($user);
        $complet = $this->isProfilComplet($profil, 'ROLE_CANDIDAT');

        $formprofil = $this->createForm(FormProfilCandidatType::class, $profil);
        $formprofil->handleRequest($request);
        $formCv = $this->createForm(FormCvType::class);
        $formCv->handleRequest($request);

        if ($formCv->isSubmitted() && $formCv->isValid()) {
            $cv = $formCv->get('cvpdf')->getData();

            if ($cv) {

                $originalFilename = pathinfo($cv->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $cv->guessExtension();

                try {
                    if ($profil->getCv() != "") {
                        unlink($this->getParameter('repertoire_cv') . '/' .  $profil->getCv());
                    }
                    $cv->move(
                        $this->getParameter('repertoire_cv'),
                        $newFilename
                    );
                    $profil->setCv($newFilename);
                    $this->entityManager->persist($profil);
                    $this->entityManager->flush();
                    $this->setProfilComplet($user, $profil, 'ROLE_CANDIDAT');
                    return $this->redirectToRoute('app_candidat');
                } catch (FileException $e) {

                    // $product->setBrochureFilename($newFilename);
                }
            }
        }
        if ($formprofil->isSubmitted() && $formprofil->isValid()) {

            $this->entityManager->persist($profil);
            $this->entityManager->flush();
            $this->setProfilComplet($user, $profil, 'ROLE_CANDIDAT');
            return $this->redirectToRoute('app_candidat');
        }

        return $this->render('candidat/candidat.html.twig', [
            'page' => 'administration',
            'onglet' => 'profil',
            'profil' => $profil,
            'formProfil' => $formprofil->createView(),
            'formcv' => $formCv->createView(),
            'complet' => $complet

        ]);
    }

    /** 
     * @Route("/candidat/annonces/", name= "app_candidat_annonce")
     * IsGranted('ROLE_CANDIDAT')
     */
    public function candidatures(): Response
    {

        $user = $this->getUser();
        $profil = $this->reposProfilCdt->findOneByUser($user);

        //  $liste = $profil->getPostuler();

        return $this->render('candidat/candidat.html.twig', [
            'page' => 'administration',
            'onglet' => 'annonce',
            //  'liste' => $liste

        ]);
    }

    /** 
     * @Route("/candidat/annonces/postuler/{id}", name= "app_candidat_annonce_postuler")
     * IsGranted('ROLE_CANDIDAT')
     */
    public function postuler($id = null, Request $request): Response
    {
        if ($id != null) {
            $user = $this->getUser();
            $profil = $this->reposProfilCdt->findOneByUser($user);
            if ($user->getValider()) {
                $annonce = $this->reposAnnonce->findOneBy(['id' => $id]);

                //  $profil->addPostuler($annonce);
                $this->entityManager->persist($profil);
                //  $annonce->addCandidat($profil);
                $this->entityManager->persist($annonce);
                $this->entityManager->flush();

                return  $this->redirectToRoute('app_candidat_annonce');
            } else   return  $this->redirectToRoute('app_candidat');
        } else   return  $this->redirectToRoute('app_candidat');
    }
}

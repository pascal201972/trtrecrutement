<?php

namespace App\Controller;

use App\Form\FormCvType;
use App\Entity\TrtProfilcandidat;
use App\Form\FormProfilCandidatType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\TrtProfilcandidatRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Spatie\PdfToImage\Pdf;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class CandidatController extends AbstractController
{
    /** 
     * @Route("/candidat/", name= "app_candidat")
     * IsGranted('ROLE_CANDIDAT')
     */
    public function index(Request $request, EntityManagerInterface $entityManager, TrtProfilcandidatRepository $reposCandidat, SluggerInterface $slugger): Response
    {
        $user = $this->getUser();
        if ($user->getTrtProfilcandidat())
            $profil = $reposCandidat->findOneByUser($user);


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
                    $entityManager->persist($profil);
                    $entityManager->flush();
                } catch (FileException $e) {

                    // $product->setBrochureFilename($newFilename);
                }
            }
        }
        if ($formprofil->isSubmitted() && $formprofil->isValid()) {

            $entityManager->persist($profil);
            $entityManager->flush();
        }

        return $this->render('candidat/candidat.html.twig', [
            'page' => 'admin',
            'profil' => $profil,
            'formProfil' => $formprofil->createView(),
            'formcv' => $formCv->createView()

        ]);
    }
}
